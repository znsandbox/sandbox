<?php

namespace yii2bundle\db\console\controllers;

use yii2rails\extension\console\base\Controller;
use yii2rails\extension\scenario\collections\ScenarioCollection;
use yii2rails\extension\scenario\helpers\ScenarioHelper;

class InitController extends Controller
{
	
	/**
	 * Use custom scripts when the project is initialized
	 *
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public function actionIndex()
	{
		$filterCollection = new ScenarioCollection($this->module->actions);
		$filterCollection->runAll();
	}
	
}
