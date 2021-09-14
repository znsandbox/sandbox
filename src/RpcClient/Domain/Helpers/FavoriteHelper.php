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
}