<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Helpers;

use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;

class FavoriteHelper
{

    public static function formToEntity(RequestForm $requestForm, FavoriteEntity $favoriteEntity = null): FavoriteEntity
    {
        $favoriteEntity = $favoriteEntity ?: new FavoriteEntity();
        $favoriteEntity->setMethod($requestForm->getMethod());
        $favoriteEntity->setBody(json_decode($requestForm->getBody()));
        $favoriteEntity->setMeta(json_decode($requestForm->getMeta()));
        $favoriteEntity->setDescription($requestForm->getDescription());
        $favoriteEntity->setAuthBy($requestForm->getAuthBy() ?: null);
        $favoriteEntity->setVersion($requestForm->getVersion());
//        $favoriteEntity->setAuthorId($this->authService->getIdentity()->getId());
        return $favoriteEntity;
    }

    public static function entityToForm(FavoriteEntity $favoriteEntity, RequestForm $requestForm): RequestForm
    {
        $requestForm->setMethod($favoriteEntity->getMethod());
        $requestForm->setMeta(json_encode($favoriteEntity->getMeta()));
        $requestForm->setBody(json_encode($favoriteEntity->getBody()));
        $requestForm->setAuthBy($favoriteEntity->getAuthBy());
        $requestForm->setDescription($favoriteEntity->getDescription());
        $requestForm->setVersion($favoriteEntity->getVersion());
        return $requestForm;
    }
}