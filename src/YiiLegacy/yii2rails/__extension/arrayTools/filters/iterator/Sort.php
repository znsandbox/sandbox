<?php

namespace ZnCore\Base\Libs\ArrayTools\Filters\Iterator;

use ZnCore\Base\Libs\Scenario\Base\BaseScenario;
use yii2rails\domain\data\Query;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

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
