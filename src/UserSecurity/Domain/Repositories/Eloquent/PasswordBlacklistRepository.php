<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Repositories\Eloquent;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserSecurity\Domain\Entities\PasswordBlacklistEntity;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Repositories\PasswordBlacklistRepositoryInterface;

class PasswordBlacklistRepository extends BaseEloquentCrudRepository implements PasswordBlacklistRepositoryInterface
{

    public function tableName() : string
    {
        return 'security_password_blacklist';
    }

    public function getEntityClass() : string
    {
        return PasswordBlacklistEntity::class;
    }

    public function isHas(string $password) : bool
    {
        $query = new Query();
        $query->where('password', $password);
        try {
            $this->one($query);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }
}
