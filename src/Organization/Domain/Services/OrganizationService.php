<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\OrganizationServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\OrganizationRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Organization\Domain\Entities\OrganizationEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\UserServiceInterface;

/**
 * @method
 * OrganizationRepositoryInterface getRepository()
 */
class OrganizationService extends BaseCrudService implements OrganizationServiceInterface
{

    private $userService;
    private $authService;

    public function __construct(
        EntityManagerInterface $em,
        UserServiceInterface $userService,
        AuthServiceInterface $authService
    )
    {
        $this->setEntityManager($em);
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function getEntityClass(): string
    {
        return OrganizationEntity::class;
    }

    public function oneCurrent(): OrganizationEntity
    {
        $identity = $this->authService->getIdentity();
        $userOrganizationEntity = $this->userService->oneByUserId($identity->getId());
        return $this->oneById($userOrganizationEntity->getOrganizationId());
    }

}
