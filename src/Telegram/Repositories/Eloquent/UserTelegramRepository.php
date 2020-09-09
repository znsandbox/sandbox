<?php

namespace ZnSandbox\Telegram\Repositories\Eloquent;

use ZnSandbox\Telegram\Entities\UserTelegramEntity;
use ZnCore\Db\Db\Base\BaseEloquentCrudRepository;

class UserTelegramRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'user_telegram';
    }

    public function getEntityClass() : string
    {
        return UserTelegramEntity::class;
    }

}
