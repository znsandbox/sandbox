<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use Casbin\ManagementEnforcer;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\ManagerRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\ManagerServiceInterface;

class ManagerService implements ManagerServiceInterface
{

    /** @var ManagementEnforcer */
    private $enforcer;

    public function __construct(ManagerRepositoryInterface $managerRepository)
    {
        $this->enforcer = $managerRepository->getEnforcer();
    }

    public function checkAccess(array $roleNames, array $permissionNames): void
    {
        $isCan = $this->isCanByRoleNames($roleNames, $permissionNames);
        if (!$isCan) {
            throw new ForbiddenException('Deny access!');
        }
    }

    public function isCanByRoleNames(array $roleNames, array $permissionNames): bool
    {
        $all = $this->allNestedItemsByRoleNames($roleNames);
        $intersect = array_intersect($permissionNames, $all);
        return !empty($intersect);
    }

    public function allNestedItemsByRoleName(string $roleName): array
    {
        return $this->enforcer->getImplicitRolesForUser($roleName);
    }

    public function allNestedItemsByRoleNames(array $roleNames): array
    {
        $all = [];
        foreach ($roleNames as $roleName) {
            $nested = $this->allNestedItemsByRoleName($roleName);
            $all = array_merge($all, $nested);
        }
        return $all;
    }
}
