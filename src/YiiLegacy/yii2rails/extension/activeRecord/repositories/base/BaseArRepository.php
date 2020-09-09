<?php

namespace yii2rails\extension\activeRecord\repositories\base;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\Inflector;
use yii2bundle\db\domain\enums\DbDriverEnum;
use yii2bundle\db\domain\helpers\ConnectionHelper;
use yii2bundle\db\domain\helpers\TableHelper;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\Query;
use yii2rails\domain\exceptions\BadQueryHttpException;
use Yii;
use yii\base\UnknownMethodException;
use yii\web\NotFoundHttpException;
use yii2rails\domain\repositories\BaseRepository;
use yii2rails\domain\values\TimeValue;
use yii2rails\extension\filedb\repositories\base\BaseActiveFiledbRepository;
use yii2rails\extension\filedb\repositories\base\BaseFiledbRepository;
use yii\helpers\ArrayHelper;

abstract class BaseArRepository extends BaseRepository {
	
	public $tableName = null;
	
	/** @var  \yii\db\ActiveRecord */
	protected $modelClass;
	
	/** @var  \yii\db\ActiveRecord */
	protected $model;
	
	/** @var  \yii\db\ActiveQuery */
	protected $query;
	protected $tableSchema;
	
	public function init() {
		parent::init();
		$this->initModel();
		$this->initQuery();
	}
	
	public function tableName()
	{
		if(!empty($this->tableName)) {
			return $this->tableName;
		}
		return $this->domain->id . BL . Inflector::underscore($this->id);
	}
	
	public function getModel() {
		return $this->model;
	}
	
	protected function resetQuery() {
		$this->initQuery();
	}
	
	public function autoIncrementField() {
		if(empty($this->tableSchema['columns'])) {
			return null;
		}
		foreach($this->tableSchema['columns'] as $name => $data) {
			if($data['autoIncrement']) {
				return $name;
			}
		}
		return null;
	}
	
	public function allFields() {
		$attributes = $this->model->attributes();
		return $this->alias->decode($attributes);
	}
	
	protected function isYiiModel($model) {
		return $model instanceof yii\db\ActiveRecord;
	}
	
	private function createVirtualModel() {
		if(isset($this->model)) {
			return;
		}
        $tableName = TableHelper::getGlobalName($this->tableName());
		$model = $this->domain->factory->model->createVirtual($tableName, $this->getParentModelClassName(), ['primaryKey'=>$this->primaryKey]);
		$this->modelClass = $model['baseName'];
		$this->model = $model['model'];
	}
	
	private function getParentModelClassName() {
		if($this instanceof BaseFiledbRepository || $this instanceof BaseActiveFiledbRepository) {
			return 'yii2rails\extension\filedb\base\FiledbActiveRecord';
		} else {
			return 'yii\db\ActiveRecord';
		}
	}
	
	private function initModel() {
		if(empty($this->modelClass)) {
			$this->createVirtualModel();
		} else {
			if(!isset($this->modelClass)) {
				$this->modelClass = $this->domain->factory->model->genClassName($this->id);
			}
			$this->model = $this->domain->factory->model->create($this->modelClass);
		}
		
		if($this->primaryKey !== false) {
			$primaryKey = $this->model->primaryKey();
		}
		if(!empty($primaryKey)) {
			$this->primaryKey = $this->alias->decode($primaryKey[0]);
		}
		if(method_exists($this->model, 'getTableSchema')) {
			$this->tableSchema = ArrayHelper::toArray($this->model->getTableSchema());
		}
	}
	
	protected function initQuery() {
		$this->query = $this->model->find();
	}
	
	protected function oneModel(Query $query = null) {
		$this->resetQuery();
		$query = Query::forge($query);
		$this->getQueryValidator()->validateSelectFields($query);
		$this->getQueryValidator()->validateWhereFields($query);
		$this->forgeQueryForOne($query);
		$this->forgeQueryForWhere($query);
		$model = $this->query->one();
		if(empty($model)) {
			throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
		}
		$modelData = $this->modelToArray($model, $query);
		return $modelData;
	}
	
	protected function allModels(Query $query = null) {
		$this->resetQuery();
		$query = Query::forge($query);
		$this->getQueryValidator()->validateSelectFields($query);
		$this->getQueryValidator()->validateWhereFields($query);
		$this->getQueryValidator()->validateSortFields($query);
		$this->forgeQueryForAll($query);
		$this->forgeQueryForWhere($query);
		try {
			$models = $this->query->all();
		} catch(InvalidArgumentException $e) {
			if(strpos($e->getMessage(), 'has no relation named') !== false) {
				throw new BadQueryHttpException('Relation not defined', 0, $e);
			} elseif(strpos($e->getMessage(), 'Invalid path alias') !== false) {
				throw new BadQueryHttpException('Invalid path alias', 0, $e);
			} else {
				throw new BadQueryHttpException(null, 0, $e);
			}
		}
		$modelData = $this->modelToArray($models, $query);
		return $modelData;
	}
	
	protected function saveModel(BaseActiveRecord $model) {
        $driver = ConnectionHelper::getDriverFromDb(Yii::$app->db);
        if($driver != DbDriverEnum::PGSQL) {
            foreach ($model as $key => $value) {
                if(is_array($value)) {
                    $value = json_encode($value);
                    $model->{$key} = $value;
                }
            }
        }
		return $model->save();
		/*try {
		
		} catch(IntegrityException $e) {
			$error = new ErrorCollection();
			if($e->getCode() == 23503 || $e->getCode() == 23000) {
				$error->add(null, 'domain/db', 'integrity_constraint_violation');
				throw new UnprocessableEntityHttpException($error);
			} elseif($e->getCode() == 23505) { //|| $e->getCode() == 23000
				$error->add(null, 'domain/db', 'already_exists');
				throw new UnprocessableEntityHttpException($error);
			} else {
				throw new BadRequestHttpException;
			}
		}
		return false;*/
	}
	
	// todo: deprecated
	protected function unsetNotExistedFields(ActiveRecord $model, $data) {
		$modelAttributes = array_keys($model->attributes);
		foreach($data as $name => $value) {
			if(!in_array($name, $modelAttributes)) {
				unset($data[ $name ]);
			}
		}
		return $data;
	}
	
	protected function unsetFieldsByKey($keys, $data) {
		if(empty($keys)) {
			return $data;
		}
		foreach($data as $name => $value) {
			if(!in_array($name, $keys)) {
				unset($data[ $name ]);
			}
		}
		return $data;
	}
	
	protected function massAssignment(BaseActiveRecord $model, BaseEntity $entity, $scenario = null) {
		$data = $entity->toArray();
		$data = $this->unsetFieldsByKey($this->allFields(), $data);
		$scenarios = $this->scenarios();
		if(!empty($scenarios[ $scenario ]) && !empty($scenario)) {
			$data = $this->unsetFieldsByKey($scenarios[ $scenario ], $data);
		}
		$dataAlias = $this->alias->encode($data);
		Yii::configure($model, $dataAlias);
	}
	
	protected function getModelExtraFields() {
		try {
			$extraFields = $this->model->extraFields();
		} catch(UnknownMethodException $e) {
			$extraFields = [];
		}
		return $extraFields;
	}
	
	protected function forgeQueryForOne(Query $query) {
		if(empty($query)) {
			return;
		}
		$q = $query->toArray();
		/*if(!empty($q['select'])) {
            $repositoryAttributes = $this->selectFields();
            $select = array_intersect_key($repositoryAttributes, $q['select']);
			$fields = $this->alias->encode($select);
			$this->query->select($fields);
		}*/
		if(!empty($q['with'])) {
			//$this->validateWithParam($q['with']);
			$with = $this->alias->encode($q['with']);
			$this->query->with($with);
		}
	}
	
	protected function forgeQueryForWhere(Query $query) {
		if(empty($query)) {
			return;
		}
		$q = $query->toArray();
		if(!empty($q['where'])) {
			$where = $this->alias->encode($q['where']);
			$this->query->where($where);
		}
	}
	
	protected function forgeQueryForAll(Query $query) {
		if(empty($query)) {
			return;
		}
		$select = $query->getParam('select');
		if($select) {
		    $this->query->select($select);
        }
		$limit = $query->getParam('limit');
		if($limit) {
			$this->query->limit($limit);
		}
		$offset = $query->getParam('offset');
		if($offset) {
			$this->query->offset($offset);
		}

        $join = $query->getParam('join');
        if($join) {
            $this->query->join($join['type'], $join['table'], $join['on'], $join['params']);
        }

		$order = $query->getParam('order');
		if($order) {
			$orderEncoded = $this->alias->encode($order);
			$this->query->orderBy($orderEncoded);
		}
		$group = $query->getParam('group');
		if ($group) {
		    $this->query->groupBy($group);
        }
		$this->forgeQueryForOne($query);
	}
	
	protected function modelToArray($model, Query $query) {
		if(empty($model)) {
			return [];
		}
		if(ArrayHelper::isIndexed($model)) {
			$list = [];
			foreach($model as $item) {
				$list[] = $this->modelItemToArray($item, $query);
			}
			return $list;
		}
		return $this->modelItemToArray($model, $query);
	}
	
	private function modelItemToArray(Model $model, Query $query) {
		$query = Query::forge($query);
		$withParam = $query->getParam('with');
		$expand = $withParam ? $withParam : [];
		$modelArray = $model->toArray([], $expand);
		return $modelArray;
	}
	
}