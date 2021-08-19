<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactServiceInterface;

class ContactService extends BaseService implements ContactServiceInterface
{

    /*private $entityEntity;

    public function __construct(EntityManagerInterface $em, EntityServiceInterface $entityService)
    {
        $this->setEntityManager($em);
        $this->entityEntity = $entityService->oneByName('personContact');
    }

    public function allByPersonId(int $personId): Collection
    {

    }*/
}
