<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use Packages\Organization\Domain\Interfaces\Services\EmployeeServiceInterface;
use Psr\Container\ContainerInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Organization\Domain\Entities\OrganizationEntity;
use ZnSandbox\Sandbox\Organization\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\OrganizationServiceInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\TypeServiceInterface;

/**
 * @method
 * OrganizationRepositoryInterface getRepository()
 */
class OrganizationService extends BaseCrudService implements OrganizationServiceInterface
{

    protected $organization;

    private $authService;
    private $container;
    private $typeService;

    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        AuthServiceInterface $authService,
        TypeServiceInterface $typeService
    )
    {
        $this->setEntityManager($em);
        $this->container = $container;
        $this->authService = $authService;
        $this->typeService = $typeService;
    }

    public function getEntityClass(): string
    {
        return OrganizationEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = Query::forge($query);
        $query->with(['type']);
        return parent::forgeQuery($query);
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
        if (empty($this->organization)) {
            $this->organization = $this->oneById($organizationId);
        }
        return $this->organization;
    }

    public function getTypeIdByCode(string $code): int
    {
        $organizationTypeId = 0;
        $typeCollection = $this->typeService->all();
        /** @var TypeEntity $typeEntity */
        foreach ($typeCollection as $typeEntity) {
            if ($typeEntity->getCode() == $code) {
                $organizationTypeId = $typeEntity->getId();
                break;
            }
        }
        return $organizationTypeId;
    }

}
