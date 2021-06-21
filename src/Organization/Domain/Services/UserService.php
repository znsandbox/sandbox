<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\UserServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\UserRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Organization\Domain\Entities\UserEntity;

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
    public function oneByUserId(int $userId) : UserEntity
    {
        $query = new Query();
        $query->where('user_id', $userId);
        $collection = $this->all($query);
        return $collection->first();
    }
}
