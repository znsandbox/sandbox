<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\AssignmentEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\AssignmentServiceInterface;

/**
 * @method AssignmentRepositoryInterface getRepository()
 */
class AssignmentService extends BaseCrudService implements AssignmentServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return AssignmentEntity::class;
    }

    public function getRolesByIdentityId(int $identityId): array
    {
        $collection = $this->getRepository()->allByIdentityId($identityId);
        return EntityHelper::getColumn($collection, 'item_name');
    }
}
