<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\ContactEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactTypeServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class ContactService extends BaseCrudService implements ContactServiceInterface
{

    protected $contactTypeService;

    public function __construct(
        EntityManagerInterface $em,
        ContactTypeServiceInterface $contactTypeService
    )
    {
        $this->setEntityManager($em);
        $this->contactTypeService = $contactTypeService;
    }

    public function getEntityClass(): string
    {
        return ContactEntity::class;
    }

    public function allByPersonId(int $personId, Query $query = null): Collection
    {
        $query = $this->forgeQuery($query);
        $query->where('person_id', $personId);
        return $this->all($query);
    }

}
