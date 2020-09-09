<?php

namespace yii2rails\app\domain\helpers;

use yii2rails\extension\scenario\collections\ScenarioCollection;
use yii2rails\extension\scenario\helpers\ScenarioHelper;

class Handler {
	
	public $filters = [];
	public $commands = [];
	
	/**
	 * @param array $data
	 *
	 * @return array|\yii2rails\domain\values\BaseValue
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public function run($data = []) {
		$filterCollection = new ScenarioCollection($this->filters);
		$data = $filterCollection->runAll($data);
		return $data;
	}
	
}
