<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Services;

use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\PasswordBlacklistServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\UserSecurity\Domain\Entities\PasswordBlacklistEntity;

class PasswordBlacklistService extends BaseCrudService implements PasswordBlacklistServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return PasswordBlacklistEntity::class;
    }

    public function isHas(string $password) : bool
    {
        return $this->getRepository()->isHas($password);
    }
}
