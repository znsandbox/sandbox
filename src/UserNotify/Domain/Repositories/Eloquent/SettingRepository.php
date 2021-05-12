<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\SettingEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\SettingRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactTypeRepositoryInterface;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class SettingRepository extends BaseEloquentCrudRepository implements SettingRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_setting';
    }

    public function getEntityClass(): string
    {
        return SettingEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'notify_type_id',
                'relationEntityAttribute' => 'notifyType',
                'foreignRepositoryClass' => TypeRepositoryInterface::class,
            ],
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'contact_type_id',
                'relationEntityAttribute' => 'contactType',
                'foreignRepositoryClass' => ContactTypeRepositoryInterface::class,
            ],
        ];
    }
}
