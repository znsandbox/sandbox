<?php

namespace yii2rails\domain\strategies\join\handlers;

use yii\helpers\ArrayHelper;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\dto\WithDto;
use yii2rails\domain\entities\relation\RelationEntity;

class One extends Many implements HandlerInterface {
	
	public function join(array $collection, RelationEntity $relationEntity) {
		$relCollection = parent::join($collection, $relationEntity);
		$relCollection = ArrayHelper::index($relCollection, $relationEntity->foreign->field);
		return $relCollection;
	}
	
	public function load(BaseEntity $entity, WithDto $w, $relCollection): RelationEntity {
		$fieldValue = $entity->{$w->relationConfig->field};
		if(empty($fieldValue)) {
			return $w->relationConfig;
		}
		if(array_key_exists($fieldValue, $relCollection)) {
			$data = $relCollection[$fieldValue];
			$data = self::prepareValue($data, $w);
			$entity->{$w->relationName} = $data;
		}
		return $w->relationConfig;
	}
	
}