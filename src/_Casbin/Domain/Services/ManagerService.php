<?php

namespace ZnUser\Rbac\Domain\Services;

use Casbin\ManagementEnforcer;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnUser\Rbac\Domain\Interfaces\Repositories\ManagerRepositoryInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\AssignmentServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class ManagerService implements ManagerServiceInterface
{

    /** @var ManagementEnforcer */
    private $enforcer;
    private $authService;
    private $assignmentService;
    private $defaultRoles = [
        //'rGuest',
    ];

    public function __construct(
        ManagerRepositoryInterface $managerRepository,
        AuthServiceInterface $authService,
        AssignmentServiceInterface $assignmentService
    )
    {
        $this->enforcer = $managerRepository->getEnforcer();
        $this->authService = $authService;
        $this->assignmentService = $assignmentService;
    }

    public function getDefaultRoles(): array
    {
        return $this->defaultRoles;
    }

    public function setDefaultRoles(array $defaultRoles): void
    {
        $this->defaultRoles = $defaultRoles;
    }

    public function checkMyAccess(array $permissionNames): void
    {
        try {
            $identityEntity = $this->authService->getIdentity();
            $roleNames = $this->assignmentService->getRolesByIdentityId($identityEntity->getId());
            $this->checkAccess($roleNames, $permissionNames);
        } catch (UnauthorizedException $e) {
            $roleNames = $this->getDefaultRoles();
            $isCan = $this->isCanByRoleNames($roleNames, $permissionNames);
            if (!$isCan) {
                throw new UnauthorizedException();
            }
        }
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
