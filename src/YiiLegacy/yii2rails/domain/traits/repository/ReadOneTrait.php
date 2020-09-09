<?php

namespace yii2rails\domain\traits\repository;

use Yii;
use yii2rails\domain\Alias;
use yii2rails\domain\data\Query;
use yii\web\NotFoundHttpException;
use yii\base\InvalidArgumentException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

/**
 * Trait ReadTrait
 *
 * @package yii2rails\domain\traits\repository
 *
 * @property $primaryKey
 */
trait ReadOneTrait {
	
	/**
	 * @return Alias
	 */
	abstract public function getAlias();
	
	public function isExistsById($id) {
		try {
			$this->oneById($id);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	/**
	 * @param array|Query $condition
	 *
	 * @return bool
	 */
	public function isExists($condition) {
		/** @var Query $query */
		$query = $this->prepareQuery();
		if(is_array($condition)) {
			$query->whereFromCondition($condition);
		} else {
			$query->where($this->primaryKey, $condition);
		}
		try {
			$this->one($query);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	public function oneByUnique(array $uniqueCond, Query $query = null) {
		$query = Query::forge($query);
		$query->where($uniqueCond);
		$entity = $this->one($query);
		return $entity;
	}
	
	public function oneById($id, Query $query = null) {
		/** @var Query $query */
		$query = Query::forge($query);
		//$query->removeParam('where');
		$query->andWhere([$this->primaryKey => $id]);
		return $this->one($query);
	}
	
	public function one(Query $query = null) {
		/** @var Query $query */
		$query = $this->prepareQuery($query);
		if(!$query->hasParam('where') /*|| $query->getParam('where') == []*/) {
			throw new InvalidArgumentException(Yii::t('domain:domain/repository', 'where_connot_be_empty'));
		};
		$query->limit(1);
		$collection = $this->all($query);
		if(empty($collection)) {
		    $message = json_encode($query->getParam(Query::WHERE));
			throw new NotFoundHttpException(get_called_class() . PHP_EOL . ' Where: ' . $message);
		}
		$entity = ArrayHelper::first($collection);
		return $entity;
	}
	
}