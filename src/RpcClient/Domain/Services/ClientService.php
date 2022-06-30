<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Domain\Service\Base\BaseService;
use ZnCore\Domain\Entity\Interfaces\UniqueInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Domain\Enums\HttpHeaderEnum;
use ZnLib\Rpc\Domain\Libs\RpcProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ClientEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\UserEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ClientServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\UserServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;

class ClientService extends BaseService implements ClientServiceInterface
{

    private $rpcProvider;
    private $authService;
//    private $authProvider;
    private $userService;

    public function __construct(
        EntityManagerInterface $em,
        RpcProvider $rpcProvider,
        AuthServiceInterface $authService,
        UserServiceInterface $userService
    )
    {
        $this->setEntityManager($em);
        $this->rpcProvider = $rpcProvider;
        $this->authService = $authService;
//        $this->authProvider = new RpcAuthProvider($this->rpcProvider);
        $this->userService = $userService;
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
        //$rpcRequestEntity->setVersion($form->getVersion());
        if ($form->getAuthBy()) {
            /** @var UserEntity $userEntity */
            $userEntity = $this->userService->findOneById($form->getAuthBy());
            $authorizationToken = $this->rpcProvider->authByLogin($userEntity->getLogin(), $userEntity->getPassword());
            $rpcRequestEntity->addMeta(HttpHeaderEnum::AUTHORIZATION, $authorizationToken);
        }
        $this->rpcProvider->prepareRequestEntity($rpcRequestEntity);
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
        /*$favoriteEntity1 = new FavoriteEntity();
        $favoriteEntity1->setMethod($form->getMethod());
        $favoriteEntity1->setBody(json_decode($form->getBody()));
        $favoriteEntity1->setMeta(json_decode($form->getMeta()));
        $favoriteEntity1->setDescription($form->getDescription());
        $favoriteEntity1->setAuthBy($form->getAuthBy() ?: null);
        $favoriteEntity1->setVersion($form->getVersion());
        $this->generateUid($favoriteEntity1);
        try {
            $favoriteEntity = $this->getEntityManager()->findOneByUnique($favoriteEntity1);
        } catch (NotFoundException $e) {
            $favoriteEntity = new FavoriteEntity();
        }*/

//            dd($favoriteEntity1);


        $favoriteEntity = new FavoriteEntity();
        $favoriteEntity->setMethod($form->getMethod());
        $favoriteEntity->setBody(json_decode($form->getBody()));
        $favoriteEntity->setMeta(json_decode($form->getMeta()));
        $favoriteEntity->setDescription($form->getDescription());
        $favoriteEntity->setAuthBy($form->getAuthBy() ?: null);
        $favoriteEntity->setVersion($form->getVersion());
        $favoriteEntity->setAuthorId($this->authService->getIdentity()->getId());
        //$this->generateUid($favoriteEntity);

        try {
            $favoriteEntityUnique = $this->getEntityManager()->findOneByUnique($favoriteEntity);
            $favoriteEntity = $favoriteEntityUnique;
//            $favoriteEntity->setStatusId($favoriteEntityUnique->getId());
//            dd($favoriteEntity);
            $isHas = true;
        } catch (NotFoundException $e) {
            $isHas = false;
        }

        //$favoriteEntity->setStatusId(StatusEnum::WAIT_APPROVING);
        if ($isHas) {
            //$favoriteEntity->setStatusId($favoriteEntitySource->getStatusId());
        } else {

        }

        /*if($favoriteEntitySource && $favoriteEntitySource->getStatusId() == StatusEnum::WAIT_APPROVING) {
            if($favoriteEntitySource->getParentId()) {
                $favoriteEntity->setParentId($favoriteEntitySource->getParentId());
            } else {
                $favoriteEntity->setParentId($favoriteEntitySource->getId());
            }
        }*/

        /* if(!$favoriteEntitySource) {
             $favoriteEntity->setStatusId(StatusEnum::WAIT_APPROVING);
         }*/
        /*try {
            $f1 = $this->getEntityManager()->findOneByUnique($favoriteEntity);
            $favoriteEntity->setStatusId($favoriteEntitySource->getStatusId());
            $favoriteEntity->setId($f1->getId());
        } catch (NotFoundException $e) {
            //if(!$favoriteEntitySource) {
                $favoriteEntity->setStatusId(StatusEnum::WAIT_APPROVING);
            //}
        }*/
        $this->getEntityManager()->persist($favoriteEntity);
    }

    public function findOneByUnique(UniqueInterface $entity): EntityIdInterface
    {
        return $this->getEntityManager()->findOneByUnique($entity);
    }

    /*public function generateUid(FavoriteEntity $favoriteEntity)
    {
        $scope = $favoriteEntity->getMethod() . json_encode($favoriteEntity->getBody()) . json_encode($favoriteEntity->getMeta()) . $favoriteEntity->getAuthBy();
        $hashBin = hash('sha1', $scope, true);
        $hash = StringHelper::base64UrlEncode($hashBin);
        $hash = rtrim($hash, '=');
        $favoriteEntity->setUid($hash);
    }*/
}
