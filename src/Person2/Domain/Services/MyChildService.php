<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnCore\Base\Exceptions\DeprecatedException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyChildService extends BaseCrudService implements MyChildServiceInterface
{

    private $myPersonService;

    public function __construct(EntityManagerInterface $em, MyPersonServiceInterface $myPersonService)
    {
        $this->setEntityManager($em);
        $this->myPersonService = $myPersonService;
    }

    public function getEntityClass(): string
    {
        return InheritanceEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $myPersonId = $this->myPersonService->one()->getId();
        $query->where('parent_person_id', $myPersonId);
        return $query;
    }

    public function deleteById($id)
    {
        $this->oneById($id);
        parent::deleteById($id);
    }

    public function updateById($id, $data)
    {
        throw new DeprecatedException('Use person method!');
//        $this->oneById($id);
//        return parent::updateById($id, $data);
    }

    public function create($data): EntityIdInterface
    {
        $myPersonId = $this->myPersonService->one()->getId();
        $data['parent_person_id'] = $myPersonId;
        return parent::create($data);
    }
}
