<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeTransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;

class TransportRepository extends BaseEloquentCrudRepository implements TransportRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_transport';
    }

    public function getEntityClass(): string
    {
        return TransportEntity::class;
    }

    public function allEnabledByTypeId(int $typeId): Collection
    {
        $query = new Query();
        $query->where('type_id', $typeId);
        $query->where('status_id', StatusEnum::ENABLED);
        $query->with('transport');
        $collectionVia = $this->getEntityManager()->all(TypeTransportEntity::class, $query);
        $array = EntityHelper::getColumn($collectionVia, 'transport');
        return new Collection($array);
    }
}
