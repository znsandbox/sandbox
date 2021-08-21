<?php

namespace ZnUser\Rbac\Domain\Services;

use Illuminate\Support\Collection;
use ZnBundle\User\Domain\Interfaces\Entities\IdentityEntityInterface;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnUser\Rbac\Domain\Entities\AssignmentEntity;
use ZnUser\Rbac\Domain\Entities\ItemEntity;
use ZnUser\Rbac\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\AssignmentServiceInterface;

/**
 * @method AssignmentRepositoryInterface getRepository()
 */
class AssignmentService extends BaseCrudService implements AssignmentServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return AssignmentEntity::class;
    }

    public function getRolesByIdentityId(int $identityId): array
    {
        $collection = $this->getRepository()->allByIdentityId($identityId);
        return EntityHelper::getColumn($collection, 'item_name');
    }

    public function allByIdentityId(int $identityId, Query $query = null): Collection
    {
        $collection = $this->getRepository()->allByIdentityId($identityId, $query);
        return $collection;
    }

    public function attach(AssignmentEntity $assignmentEntity) {
        $this->checkExists($assignmentEntity);
        $this->validate($assignmentEntity);
        $this->getEntityManager()->persist($assignmentEntity);
    }

    public function detach(AssignmentEntity $assignmentEntity) {
        $this->validate($assignmentEntity);
        $this->getEntityManager()->remove($assignmentEntity);
    }

    private function checkExists(AssignmentEntity $assignmentEntity) {
        $assignmentQuery = new Query();
        $assignmentQuery->where('item_name', $assignmentEntity->getItemName());
        $assignmentQuery->where('identity_id', $assignmentEntity->getIdentityId());
        try {
            $assignmentEntity = $this->getEntityManager()->one(AssignmentEntity::class, $assignmentQuery);
            throw new AlreadyExistsException('Assignment already exists');
        } catch (NotFoundException $e) {}
    }

    private function validate(AssignmentEntity $assignmentEntity) {
        $unprocessibleEntityException = new UnprocessibleEntityException();

        try {
            $identityEntity = $this->getEntityManager()->oneById(IdentityEntityInterface::class, $assignmentEntity->getIdentityId());
        } catch (NotFoundException $e) {
            $unprocessibleEntityException->add('identityId', 'User not found');
        }

        $itemQuery = new Query();
        $itemQuery->where('name', $assignmentEntity->getItemName());
        try {
            $itemEntity = $this->getEntityManager()->one(ItemEntity::class, $itemQuery);
        } catch (NotFoundException $e) {
            $unprocessibleEntityException->add('itemName', 'Item not found');
        }

        if($unprocessibleEntityException->getErrorCollection() && $unprocessibleEntityException->getErrorCollection()->count() > 0) {
            throw $unprocessibleEntityException;
        }
    }
}
