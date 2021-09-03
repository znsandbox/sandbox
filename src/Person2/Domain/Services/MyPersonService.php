<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\PersonRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyPersonService extends BaseService implements MyPersonServiceInterface
{

    private $authService;
    private $personRepository;

    public function __construct(EntityManagerInterface $em, AuthServiceInterface $authService, PersonRepositoryInterface $personRepository)
    {
        $this->setEntityManager($em);
        $this->authService = $authService;
        $this->personRepository = $personRepository;
    }

    public function one(Query $query): PersonEntity
    {
        $identityId = $this->authService->getIdentity()->getId();
        return $this->personRepository->oneByIdentityId($identityId, $query);
    }

    public function update(array $data): void
    {
        if(isset($data['id'])) {
            unset($data['id']);
        }
        $personEntity = $this->one();
        EntityHelper::setAttributes($personEntity, $data);
        $this->getEntityManager()->persist($personEntity);
    }
}