<?php

namespace ZnSandbox\Sandbox\Person\Domain\Services;

use ZnCore\Base\Libs\Text\Helpers\TextHelper;
use ZnSandbox\Sandbox\Person\Domain\Interfaces\Services\PersonServiceInterface;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Forms\DynamicForm;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\ValueServiceInterface;
use ZnBundle\User\Domain\Entities\IdentityEntity;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Base\Exceptions\NotFoundException;

use ZnCore\Base\Libs\Service\Base\BaseService;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnKaz\Iin\Domain\Helpers\IinParser;

class PersonService extends BaseService implements PersonServiceInterface
{

    protected $identityService;
    protected $entityService;
    protected $valueService;
    protected $authService;

    public function __construct(
        EntityServiceInterface $entityService,
        ValueServiceInterface $valueService,
        AuthServiceInterface $authService,
        IdentityServiceInterface $identityService
    )
    {
        $this->entityService = $entityService;
        $this->valueService = $valueService;
        $this->authService = $authService;
        $this->identityService = $identityService;
    }

    protected function idFromName(string $entityName): int
    {
        $entityEntity = $this->entityService->oneByName($entityName);
        return $entityEntity->getId();
    }

    public function oneByAuth(string $entityName): DynamicEntity
    {
        $identityId = $this->authService->getIdentity()->getId();
        try {
            $entity = $this->oneById($entityName, $identityId);
        } catch (NotFoundException $e) {
            $entity = $this->entityService->createEntityById($this->idFromName($entityName));
        }
        return $entity;
    }

    public function oneById(string $entityName, int $id): DynamicEntity
    {
        return $this->valueService->oneRecord($this->idFromName($entityName), $id);
    }

    public function createForm(string $entityName, array $attributes = []): DynamicForm
    {
        $dynamicForm = $this->entityService->createFormById($this->idFromName($entityName));
        if ($attributes) {
            EntityHelper::setAttributes($dynamicForm, $attributes);
        }
        return $dynamicForm;
    }

    public function updateMyData(string $entityName, DynamicForm $form): void
    {
        $identityId = $this->authService->getIdentity()->getId();
        $this->updateById($entityName, $form, $identityId);
    }

    public function updateById(string $entityName, DynamicForm $form, int $recordId): void
    {
        if ($entityName == 'person_info') {
            $this->validateBirthDate($form);
        }
        $dynamicEntity = $this->entityService->createEntityById($this->idFromName($entityName));
        EntityHelper::setAttributes($dynamicEntity, $form->toArray());
        $dynamicEntity->setId($recordId);

        $this->entityService->validateEntity($dynamicEntity);

        if ($entityName == 'person_info') {
            $this->validateBirthDate($form);
        }

        $this->entityService->updateEntity($dynamicEntity);
        if ($entityName == 'person_info') {
            $this->updateIdentity($form, $recordId);
        }
    }

    private function updateIdentity(DynamicForm $form, int $recordId)
    {
        /** @var IdentityEntity $identityEntity */
        $identityEntity = $this->identityService->oneById($recordId);
        $firstName = EntityHelper::getValue($form, 'firstName');
        $lastName = EntityHelper::getValue($form, 'lastName');
        $fullName = $firstName . ' ' . $lastName;
        $identityEntity->setUsername($fullName);
        $this->identityService->updateById($identityEntity->getId(), EntityHelper::toArray($identityEntity));
        // todo: обновить сессию
//        $this->getEntityManager()->persist($identityEntity);
    }

    private function validateBirthDate(DynamicForm $form)
    {
        $iinValue = EntityHelper::getValue($form, 'iin');
        try {
            $iinEntity = IinParser::parse($iinValue);
        } catch (\Exception $e) {
            $exception = new UnprocessibleEntityException();
            $exception->add('iin', 'Bad iin');
            throw $exception;
        }
        $birthDay =
            $iinEntity->getBirthday()->getYear()
            . '-' .
            TextHelper::fill($iinEntity->getBirthday()->getMonth(), 2, '0', 'before')
            . '-' .
            TextHelper::fill($iinEntity->getBirthday()->getDay(), 2, '0', 'before');
        $birthDayValue = EntityHelper::getValue($form, 'birthDate');
        if ($birthDay != $birthDayValue) {
            $exception = new UnprocessibleEntityException();
            $exception->add('birthDate', 'Birthday and IIN not equal');
            throw $exception;
        }
    }
}
