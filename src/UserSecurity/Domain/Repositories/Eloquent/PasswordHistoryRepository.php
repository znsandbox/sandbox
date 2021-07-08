<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserSecurity\Domain\Entities\PasswordHistoryEntity;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Repositories\PasswordHistoryRepositoryInterface;

class PasswordHistoryRepository extends BaseEloquentCrudRepository implements PasswordHistoryRepositoryInterface
{

    public function tableName() : string
    {
        return 'security_password_history';
    }

    public function getEntityClass() : string
    {
        return PasswordHistoryEntity::class;
    }

    public function allByIdentityId(int $identityId): Collection
    {
        $query = new Query();
        $query->where('identity_id', $identityId);
        return $this->all($query);
    }
}
