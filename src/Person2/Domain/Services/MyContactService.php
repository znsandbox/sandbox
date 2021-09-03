<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactRepositoryInterface;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\ContactEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactTypeServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyContactServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

/**
 * @method ContactRepositoryInterface getRepository()
 */
class MyContactService extends BaseCrudService implements MyContactServiceInterface
{

    private $myPersonService;
    private $contactTypeService;

    public function __construct(
        EntityManagerInterface $em,
        MyPersonServiceInterface $myPersonService,
        ContactTypeServiceInterface $contactTypeService
    )
    {
        $this->setEntityManager($em);
        $this->myPersonService = $myPersonService;
        $this->contactTypeService = $contactTypeService;
    }

    public function getEntityClass(): string
    {
        return ContactEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $myPersonId = $this->myPersonService->one()->getId();
        $query->where('person_id', $myPersonId);
        return $query;
    }

    public function deleteById($id)
    {
        $this->oneById($id);
        parent::deleteById($id);
    }

    public function updateById($id, $data)
    {
        $this->oneById($id);
        return parent::updateById($id, $data);
    }

    public function createBatch($data): void
    {
        $typeCollection = $this->contactTypeService->all();
        $typeCollection = EntityHelper::indexingCollection($typeCollection, 'name');
        foreach ($data as $name => $values) {
            /** @var AttributeEntity $typeEntity */
            $typeEntity = $typeCollection[$name];
            foreach ($values as $value) {
                $contactType = new ContactEntity();
                /*$contactType->setAttributeId($value);
                $contactType->setValue($typeEntity->getId());
                $this->getEntityManager()->persist($contactType);*/

                $item = [
                    "value" => $value,
                    "attributeId" => $typeEntity->getId(),
                ];
                try {
                    $this->create($item);
                } catch (AlreadyExistsException $e) {
                    /*$errors = new UnprocessibleEntityException;
                    $errors->add($name, $e->getMessage());
                    throw $errors;*/
                }
            }
        }
    }

    public function create($data): EntityIdInterface
    {
        $myPersonId = $this->myPersonService->one()->getId();
        $data['person_id'] = $myPersonId;
        return parent::create($data);
    }
}
