<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\ManagerRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\ManagerServiceInterface;
use Casbin\ManagementEnforcer;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class ManagerService extends BaseService implements ManagerServiceInterface
{

    /** @var ManagementEnforcer */
    private $enforcer;

    public function __construct(EntityManagerInterface $entityManager, InheritanceRepositoryInterface $inheritanceRepository, ManagerRepositoryInterface $managerRepository)
    {
        $this->setEntityManager($entityManager);
        $this->enforcer = $managerRepository->getEnforcer();
    }

    public function checkAccess(array $roleNames, array $permissionNames)
    {
        $isCan = $this->isCanByRoleNames($roleNames, $permissionNames);
        if (!$isCan) {
            throw new ForbiddenException('Deny access!');
        }
    }

    public function allNestedRolesByRoleName(string $roleName)
    {
        return $this->enforcer->getImplicitRolesForUser($roleName);
    }

    public function allNestedRolesByRoleNames(array $roleNames): array
    {
        $all = [];
        foreach ($roleNames as $roleName) {
            $nested = $this->allNestedRolesByRoleName($roleName);
            $all = array_merge($all, $nested);
        }
        return $all;
    }

    public function isCanByRoleNames(array $roleNames, array $permissionNames): bool
    {
        $all = $this->allNestedRolesByRoleNames($roleNames);
        $intersect = array_intersect($permissionNames, $all);
        return !empty($intersect);
    }
}
