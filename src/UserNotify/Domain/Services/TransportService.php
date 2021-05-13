<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeTransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TransportServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;

class TransportService extends BaseCrudService implements TransportServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return TransportEntity::class;
    }

    public function allByTypeId(int $typeId) {
        $query = new Query();
        $query->where('type_id', $typeId);
        $query->with('transport');
        $collectionVia = $this->getEntityManager()->all(TypeTransportEntity::class, $query);
        $array = EntityHelper::getColumn($collectionVia, 'transport');
        return new Collection($array);
    }
}
