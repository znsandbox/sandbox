<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValidationRepositoryInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeTransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeTransportRepositoryInterface;

class TypeTransportRepository extends BaseEloquentCrudRepository implements TypeTransportRepositoryInterface
{

    public function tableName() : string
    {
        return 'notify_type_transport';
    }

    public function getEntityClass() : string
    {
        return TypeTransportEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'transport_id',
                'relationEntityAttribute' => 'transport',
                'foreignRepositoryClass' => TransportRepositoryInterface::class,
            ],
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'type_id',
                'relationEntityAttribute' => 'type',
                'foreignRepositoryClass' => TypeRepositoryInterface::class,
            ],
        ];
    }
}
