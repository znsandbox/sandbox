<?php

namespace yii2bundle\rbac\domain\services;

use yii\web\NotFoundHttpException;
use yii2bundle\rbac\domain\entities\AssignmentEntity;
use yii2rails\domain\data\Query;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;
use yii2rails\domain\services\base\BaseActiveService;
use yii2bundle\rbac\domain\interfaces\services\AssignmentInterface;
use yii2bundle\rbac\domain\repositories\disc\AssignmentRepository;

/**
 * Class AssignmentService
 *
 * @package yii2bundle\rbac\domain\services
 *
 * @property \yii2bundle\rbac\domain\Domain $domain
 * @property AssignmentRepository $repository
 */
class AssignmentService extends BaseActiveService implements AssignmentInterface {
	
	/**
	 * @var array
	 */
	protected $assignments = []; // userId, itemName => assignment
	
	/*private function allByUserId(int $userId) {
		return $this->repository->allByUserId($userId);
	}*/

	public function oneById($id, Query $query = null)
    {
        list($userId, $itemName) = explode(BL, $id);
        $query = new Query;
        $query->andWhere([
            'item_name' => $itemName,
            'user_id' => $userId,
        ]);
        $assignmentEntity = $this->one($query);
        return $assignmentEntity;
    }

    public function deleteById($id)
    {
        $assignmentEntity = $this->oneById($id);
        $this->revoke($assignmentEntity->item_name, $assignmentEntity->user_id);
        //return $this->repository->delete($assignmentEntity);
    }

    public function create($data)
    {
        $assignmentEntity = new AssignmentEntity($data);

        try {
            \App::$domain->rbac->role->oneById($assignmentEntity->item_name);
        } catch (NotFoundHttpException $e) {
            $error = new ErrorCollection;
            $error->add('item_name', 'main', 'not_found');
            throw new UnprocessableEntityHttpException($error);
        }

        try {
            \App::$domain->account->login->oneById($assignmentEntity->user_id);
        } catch (NotFoundHttpException $e) {
            $error = new ErrorCollection;
            $error->add('user_id', 'main', 'not_found');
            throw new UnprocessableEntityHttpException($error);
        }

        $isHasRole = $this->isHasRole($assignmentEntity->user_id, $assignmentEntity->item_name);
        if($isHasRole) {
            $error = new ErrorCollection;
            $error->add('user_id', 'main', 'already_exists');
            throw new UnprocessableEntityHttpException($error);
        }

        $this->assign($assignmentEntity->item_name, $assignmentEntity->user_id);
    }

    public function allRoleNamesByUserId(int $userId) {
		return $this->repository->allRoleNamesByUserId($userId);
	}
	
	public function getAssignments($userId) {
		if(empty($userId)) {
			return [];
		}
		return $this->repository->getAssignments($userId);
	}
	
	public function getAssignment($roleName, $userId) {
		return $this->repository->getAssignment($roleName, $userId);
	}
	
	public function assign($role, $userId) {
		return $this->repository->assign($role, $userId);
	}
	
	public function revoke($role, $userId) {
		return $this->repository->revoke($role, $userId);
	}
	
	public function revokeAll($userId) {
		return $this->repository->revokeAll($userId);
	}
	
	public function revokeAllByItemName($itemName) {
		return $this->repository->revokeAllByItemName($itemName);
	}
	
	public function updateRoleName($itemName, $newItemName) {
		$this->repository->updateRoleName($itemName, $newItemName);
	}
	
	public function isHasRole($userId, $roleName) {
		return $this->repository->isHasRole($userId, $roleName);
	}
	
	public function getUserIdsByRole($roleName) {
		return $this->repository->getUserIdsByRole($roleName);
	}
	
	public function updateItem($name, $item) {
		//return $this->repository->updateItem($name, $item);
	}
	
	/**
	 * @inheritdoc
	 */
	public function removeItem($item)
	{
		//return $this->repository->removeItem($item);
	}
	
	public function removeAllAssignments()
	{
		//return $this->repository->removeAllAssignments();
	}
}

