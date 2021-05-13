<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TransportServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;

class TypeService extends BaseCrudService implements TypeServiceInterface
{

    private $transportService;

    public function __construct(EntityManagerInterface $em, TypeRepositoryInterface $repository, TransportServiceInterface $transportService)
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
        $this->transportService = $transportService;
    }

    public function oneByIdWithI18n(int $id): TypeEntity
    {
        $query = new Query();
        $query->with(['i18n']);
        /** @var TypeEntity $typeEntity */
        $typeEntity = $this->getEntityManager()->oneById(TypeEntity::class, $id, $query);
        //$transportCollection = $this->transportService->allByTypeId($id);
        //$typeEntity->setTransports($transportCollection);
        return $typeEntity;
    }

    public function oneByName(string $name): TypeEntity
    {
        $query = new Query();
        $query->where('name', $name);
        $query->with('transports');
        /** @var TypeEntity $typeEntity */
        $typeEntity = $this->getEntityManager()->one(TypeEntity::class, $query);
        return $typeEntity;
    }
}
