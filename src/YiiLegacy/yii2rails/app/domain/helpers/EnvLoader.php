<?php

namespace yii2rails\app\domain\helpers;

use yii2rails\extension\scenario\collections\ScenarioCollection;
use yii2rails\extension\scenario\helpers\ScenarioHelper;
use yii2rails\extension\common\helpers\Helper;

class EnvLoader
{
	
	/**
	 * @param $definition
	 *
	 * @return \yii2rails\domain\values\BaseValue
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public static function run($definition) {
		$filterCollection = new ScenarioCollection($definition['filters']);
		$config = $filterCollection->runAll([]);
		$definition['commands'] = Helper::assignAttributesForList($definition['commands'], [
			'env' => $config,
		]);
		$filterCollection = new ScenarioCollection($definition['commands']);
		$filterCollection->runAll();
		return $config;
	}
	
}
