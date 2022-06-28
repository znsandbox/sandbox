<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Wsdl\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\Wsdl\Domain\Enums\StatusEnum;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use Illuminate\Support\Enumerable;
use ZnCore\Domain\Query\Entities\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class TransportRepository extends BaseEloquentCrudRepository implements TransportRepositoryInterface
{

    public function tableName(): string
    {
        return 'wsdl_transport';
    }

    public function getEntityClass(): string
    {
        return TransportEntity::class;
    }

    public function allByNewStatus(Query $query = null): Enumerable
    {
        $query = $this->forgeQuery($query);
//        $query->limit(10);
        $query->where('status_id', StatusEnum::NEW);
        return $this->all($query);
    }
}
