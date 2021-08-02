<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use Packages\News\Domain\Subscribers\SyncViewCountSubscriber;
use Packages\Organization\Domain\Interfaces\Services\EmployeeServiceInterface;
use Packages\Organization\Domain\Subscribers\OrganizationSubscriber;
use Psr\Container\ContainerInterface;
use ZnBundle\Storage\Domain\Subscribers\StoreHtmlResourceBehavior;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Libs\Query;
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

//    private $employeeService;
    private $authService;
    private $container;

    public function __construct(
        EntityManagerInterface $em,
//        EmployeeServiceInterface $employeeService,
        ContainerInterface $container,
        AuthServiceInterface $authService
    )
    {
        $this->setEntityManager($em);
//        $this->employeeService = $employeeService;
        $this->container = $container;
        $this->authService = $authService;
    }

    public function getEntityClass(): string
    {
        return OrganizationEntity::class;
    }

    public function subscribes(): array
    {
        return [
            OrganizationSubscriber::class
        ];
    }

    public function getCurrentOrganizationId(): int
    {
        $identity = $this->authService->getIdentity();
        /** @var EmployeeServiceInterface $employeeService */
        $employeeService = $this->container->get(EmployeeServiceInterface::class);
        $employeeEntity = $employeeService->oneByUserId($identity->getId());
        return $employeeEntity->getOrganizationId();
    }

    public function oneCurrent(): OrganizationEntity
    {
        $organizationId = $this->getCurrentOrganizationId();
        return $this->oneById($organizationId);
    }

}
