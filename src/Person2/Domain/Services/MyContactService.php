<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use App\Contact\Domain\Entities\ValueEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyContactServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

/**
 * @method ContactRepositoryInterface getRepository()
 */
class MyContactService extends BaseCrudService implements MyContactServiceInterface
{

    private $myPersonService;
    private $eavEntity;

    public function __construct(EntityManagerInterface $em, MyPersonServiceInterface $myPersonService, EntityServiceInterface $entityService)
    {
        $this->setEntityManager($em);
        $this->myPersonService = $myPersonService;
        $this->eavEntity = $entityService->oneByName('personContact');
    }

    public function getEntityClass(): string
    {
        return ValueEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $myPersonId = $this->myPersonService->one()->getId();
        $query->where('entity_id', $this->eavEntity->getId());
        $query->where('record_id', $myPersonId);
        return $query;
    }
}
