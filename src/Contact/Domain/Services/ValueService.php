<?php

namespace ZnSandbox\Sandbox\Contact\Domain\Services;

use ZnSandbox\Sandbox\Contact\Domain\Interfaces\Services\ValueServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Contact\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Contact\Domain\Entities\ValueEntity;

/**
 * @method ValueRepositoryInterface getRepository()
 */
class ValueService extends BaseCrudService implements ValueServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return ValueEntity::class;
    }
}
