<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactRepositoryInterface;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Libs\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\ContactEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactTypeServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyContactServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

/**
 * @method ContactRepositoryInterface getRepository()
 */
class MyContactService extends ContactService implements MyContactServiceInterface
{

    private $myPersonService;

    public function __construct(
        EntityManagerInterface $em,
        MyPersonServiceInterface $myPersonService,
        ContactTypeServiceInterface $contactTypeService
    )
    {
        parent::__construct($em, $contactTypeService);
        $this->myPersonService = $myPersonService;
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
        $typeCollection = CollectionHelper::indexing($typeCollection, 'name');
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
                    $errors = new UnprocessibleEntityException;
                    $errors->add($name, $e->getMessage());
                    throw $errors;
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
