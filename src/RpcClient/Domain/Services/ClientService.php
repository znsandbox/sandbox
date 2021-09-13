<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Legacy\Yii\Helpers\StringHelper;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Domain\Libs\RpcProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ClientEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ClientServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;

class ClientService extends BaseService implements ClientServiceInterface
{

    private $rpcProvider;
    private $authService;

    public function __construct(
        EntityManagerInterface $em,
        RpcProvider $rpcProvider,
        AuthServiceInterface $authService
    )
    {
        $this->setEntityManager($em);
        $this->rpcProvider = $rpcProvider;
        $this->authService = $authService;
    }

    public function sendRequest(RequestForm $form, FavoriteEntity $favoriteEntity = null): RpcResponseEntity
    {
        $rpcResponseEntity = $this->send($form);
        $this->saveToHistory($form, $favoriteEntity);
        return $rpcResponseEntity;
    }

    public function formToRequestEntity(RequestForm $form): RpcRequestEntity
    {
        $rpcRequestEntity = new RpcRequestEntity();
        $rpcRequestEntity->setMethod($form->getMethod());
        $rpcRequestEntity->setParams(json_decode($form->getBody(), JSON_OBJECT_AS_ARRAY));
        $rpcRequestEntity->setMeta(json_decode($form->getMeta(), JSON_OBJECT_AS_ARRAY));
        return $rpcRequestEntity;
    }
    
    private function send(RequestForm $form): RpcResponseEntity
    {
        $rpcRequestEntity = $this->formToRequestEntity($form);
        $rpcResponseEntity = $this->rpcProvider->sendRequestByEntity($rpcRequestEntity);
        return $rpcResponseEntity;
    }

    private function saveToHistory(RequestForm $form, FavoriteEntity $favoriteEntitySource = null)
    {
        $favoriteEntity = new FavoriteEntity();
        $favoriteEntity->setMethod($form->getMethod());
        $favoriteEntity->setBody(json_decode($form->getBody()));
        $favoriteEntity->setMeta(json_decode($form->getMeta()));
        $favoriteEntity->setDescription($form->getDescription());
        $favoriteEntity->setStatusId(StatusEnum::WAIT_APPROVING);
        if($favoriteEntitySource) {
            if($favoriteEntitySource->getParentId()) {
                $favoriteEntity->setParentId($favoriteEntitySource->getParentId());
            } else {
                $favoriteEntity->setParentId($favoriteEntitySource->getId());
            }
        }
        $favoriteEntity->setAuthorId($this->authService->getIdentity()->getId());
        $this->generateUid($favoriteEntity);
        $this->getEntityManager()->persist($favoriteEntity);
    }

    private function generateUid(FavoriteEntity $favoriteEntity)
    {
        $scope = $favoriteEntity->getMethod() . json_encode($favoriteEntity->getBody()) . json_encode($favoriteEntity->getMeta()) . $favoriteEntity->getAuthBy();
        $hashBin = hash('sha1', $scope, true);
        $hash = StringHelper::base64UrlEncode($hashBin);
        $hash = rtrim($hash, '=');
        $favoriteEntity->setUid($hash);
    }
}
