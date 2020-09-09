<?php

namespace yii2rails\extension\arrayTools\traits;

use yii\helpers\ArrayHelper;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\Query;
use yii\web\NotFoundHttpException;
use yii2rails\domain\Domain;

/**
 * Trait ArrayModifyTrait
 *
 * @package yii2rails\extension\arrayTools\traits
 *
 * @property string $id
 * @property string $primaryKey
 * @property Domain $domain
 */
trait ArrayModifyTrait {

	abstract public function oneById($id, Query $query = null);
	abstract protected function getCollection();
	abstract protected function setCollection(Array $collection);

	public function insert(BaseEntity $entity) {
		$collection = $this->getCollection();
		$collection[] = $entity->toArray();
		$this->setCollection($collection);
	}

	public function update(BaseEntity $entity) {
		$entityBase = $this->oneById($entity->{$this->primaryKey});
		$index = $this->getIndexOfEntity($entityBase);
		$collection = $this->getCollection();
		$collection[$index] = $entity->toArray();
		$this->setCollection($collection);
	}

	public function delete(BaseEntity $entity) {
		$index = $this->getIndexOfEntity($entity);
		$collection = $this->getCollection();
		unset($collection[$index]);
		$this->setCollection($collection);
	}

    public function truncate() {
        $this->setCollection([]);
    }

	protected function getIndexOfEntity(BaseEntity $entity) {
		$collection = $this->getCollection();
		foreach($collection as $index => $data) {
			if(ArrayHelper::getValue($data, $this->primaryKey) == ArrayHelper::getValue($entity, $this->primaryKey)) {
				return $index;
			}
		}
		throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
	}

}