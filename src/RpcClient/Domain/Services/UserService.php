<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\UserServiceInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\UserRepositoryInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\UserEntity;

/**
 * @method
 * UserRepositoryInterface getRepository()
 */
class UserService extends BaseCrudService implements UserServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return UserEntity::class;
    }


}

