<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnUser\Authentication\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Service\Base\BaseService;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\PersonRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyPersonService extends BaseService implements MyPersonServiceInterface
{

    private $authService;
    private $personRepository;
    private $inheritanceRepository;

    public function __construct(
        EntityManagerInterface $em,
        AuthServiceInterface $authService,
        PersonRepositoryInterface $personRepository,
        InheritanceRepositoryInterface $inheritanceRepository
    )
    {
        $this->setEntityManager($em);
        $this->authService = $authService;
        $this->personRepository = $personRepository;
        $this->inheritanceRepository = $inheritanceRepository;
    }

    public function findOne(Query $query = null): PersonEntity
    {
        $identityId = $this->authService->getIdentity()->getId();
        return $this->personRepository->findOneByIdentityId($identityId, $query);
    }

    public function update(array $data): void
    {
        if(isset($data['id'])) {
            //unset($data['id']);
        }
        $personEntity = $this->findOne();
        //dump($personEntity);
        EntityHelper::setAttributes($personEntity, $data);
        $this->getEntityManager()->update($personEntity);
    }

    public function isMyChild($id)
    {
        $parentEntityId = $this->findOne()->getId();
        $childEntityId = $this->personRepository->findOneById($id)->getId();

        $query = new Query();
        $query->where('parent_person_id', $parentEntityId);
        $query->where('child_person_id', $childEntityId);
        $childrenEntity = $this->inheritanceRepository->findAll($query);

        if ($childrenEntity->count() > 0) {
            return true;
        }

        return false;
    }
}