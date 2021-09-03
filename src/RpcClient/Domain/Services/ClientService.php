<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
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

/**
 * @method
 * ClientRepositoryInterface getRepository()
 */
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

    public function sendRequest(RequestForm $form): RpcResponseEntity
    {
        $rpcResponseEntity = $this->send($form);
        $this->saveToHistory($form);
        return $rpcResponseEntity;
    }

    private function send(RequestForm $form): RpcResponseEntity
    {
        $rpcRequestEntity = new RpcRequestEntity();
        $rpcRequestEntity->setMethod($form->getMethod());
        $rpcRequestEntity->setParams(json_decode($form->getBody(), JSON_OBJECT_AS_ARRAY));
        $rpcRequestEntity->setMeta(json_decode($form->getMeta(), JSON_OBJECT_AS_ARRAY));
        $rpcResponseEntity = $this->rpcProvider->sendRequestByEntity($rpcRequestEntity);
        return $rpcResponseEntity;
    }

    private function saveToHistory(RequestForm $form)
    {
        $favoriteEntity = new FavoriteEntity();
        $favoriteEntity->setMethod($form->getMethod());
        $favoriteEntity->setBody($form->getBody());
        $favoriteEntity->setMeta($form->getMeta());
        $favoriteEntity->setDescription($form->getDescription());
        $favoriteEntity->setAuthorId($this->authService->getIdentity()->getId());

        $scope = $favoriteEntity->getMethod() . $favoriteEntity->getBody() . $favoriteEntity->getMeta() . $favoriteEntity->getAuthBy();
        $hashBin = hash('sha1', $scope, true);
        $hash = StringHelper::base64UrlEncode($hashBin);
        $hash = rtrim($hash, '=');
        $favoriteEntity->setUid($hash);

        $this->getEntityManager()->persist($favoriteEntity);
    }
}
