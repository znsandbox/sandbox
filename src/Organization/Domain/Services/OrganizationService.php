<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use App\Organization\Domain\Enums\Rbac\OrganizationOrganizationPermissionEnum;
use App\Organization\Domain\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Organization\Domain\Interfaces\Services\EmployeeServiceInterface;
use Psr\Container\ContainerInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Organization\Domain\Entities\OrganizationEntity;
use ZnSandbox\Sandbox\Organization\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\OrganizationRepositoryInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\SwitchRepositoryInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\OrganizationServiceInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\TypeServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

/**
 * @method OrganizationRepositoryInterface getRepository()
 */
class OrganizationService extends BaseCrudService implements OrganizationServiceInterface
{

    protected $organization;

    private $authService;
    private $container;
    private $typeService;
    private $employeeRepository;
    private $switchRepository;
//    private $managerService;

    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        AuthServiceInterface $authService,
        EmployeeRepositoryInterface $employeeRepository,
        SwitchRepositoryInterface $switchRepository,
//        ManagerServiceInterface $managerService,
        TypeServiceInterface $typeService
    )
    {
        $this->setEntityManager($em);
        $this->container = $container;
        $this->authService = $authService;
        $this->employeeRepository = $employeeRepository;
        $this->switchRepository = $switchRepository;
//        $this->managerService = $managerService;
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

    public function getCurrentOrganizationId(): ?int
    {
        $id = $this->switchRepository->getId();
//        $managerService = ContainerHelper::getContainer()->get(ManagerServiceInterface::class);
//        $iCan = $managerService->iCan([OrganizationOrganizationPermissionEnum::SWITCH]);
        if($id) {
            return $id;
        }
        $identity = $this->authService->getIdentity();

//        /** @var EmployeeServiceInterface $employeeService */
//        $employeeService = $this->container->get(EmployeeServiceInterface::class);
        $employeeEntity = $this->employeeRepository->oneByUserId($identity->getId());
        return $employeeEntity->getOrganizationId();
    }

    public function setCurrentOrganizationId(?int $id): void
    {
        $this->switchRepository->setId($id);
    }

    public function oneCurrent(): OrganizationEntity
    {
        $organizationId = $this->getCurrentOrganizationId();
        if (empty($this->organization)) {
            if($organizationId < 0) {
                $this->organization = $this->getEntityManager()->createEntity(OrganizationEntity::class);
//                $this->organization = new OrganizationEntity();
                $this->organization->setId($organizationId);
                $this->organization->setTitle('Null');
                $type = new TypeEntity();
                $type->setCode('uo');
                $this->organization->setType($type);
            } else {
                $this->organization = $this->oneById($organizationId);
            }
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
