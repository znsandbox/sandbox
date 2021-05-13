<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeI18nRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeTransportRepositoryInterface;

class TypeRepository extends BaseEloquentCrudRepository implements TypeRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_type';
    }

    public function getEntityClass(): string
    {
        return TypeEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'i18n',
                'foreignRepositoryClass' => TypeI18nRepositoryInterface::class,
                'foreignAttribute' => 'type_id',
            ],
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'transports',
                'foreignRepositoryClass' => TypeTransportRepositoryInterface::class,
                'foreignAttribute' => 'type_id',
            ],


            /*[
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'transports',
                'foreignRepositoryClass' => TypeTransportRepositoryInterface::class,
                'foreignAttribute' => 'type_id',
            ],*/
        ];
    }
}
