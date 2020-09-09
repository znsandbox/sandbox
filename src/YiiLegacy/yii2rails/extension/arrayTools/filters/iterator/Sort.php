<?php

namespace yii2rails\extension\arrayTools\filters\iterator;

use yii2rails\extension\scenario\base\BaseScenario;
use yii2rails\domain\data\Query;
use yii2rails\extension\yii\helpers\ArrayHelper;

class Sort extends BaseScenario {

	public $query;
	
	public function run() {
		$collection = $this->getData();
		$collection = $this->filterSort($collection, $this->query);
		$this->setData($collection);
	}
	
	protected function filterSort(Array $collection, Query $query) {
		$orders = $query->getParam('order');
		if (empty($orders)) {
			return $collection;
		}
		ArrayHelper::multisort($collection, array_keys($orders), array_values($orders));
		return $collection;
	}
}
