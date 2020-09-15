<?php

namespace yii2rails\extension\code\filters\parser;

use ZnCore\Base\Libs\Scenario\Base\BaseScenario;

abstract class Base extends BaseScenario {
	
	public function getData() {
		$collection =  parent::getData();
		$collection = array_values($collection);
		return $collection;
	}
	
	public function setData($collection) {
		$collection = array_values($collection);
		parent::setData($collection);
	}
	
}
