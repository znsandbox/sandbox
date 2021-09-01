<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\FavoriteRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;

/**
 * @method
 * FavoriteRepositoryInterface getRepository()
 */
class FavoriteService extends BaseCrudService implements FavoriteServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return FavoriteEntity::class;
    }


}

