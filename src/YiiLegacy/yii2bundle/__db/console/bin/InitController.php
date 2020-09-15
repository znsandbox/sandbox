<?php

namespace yii2bundle\db\console\bin;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2rails\domain\data\EntityCollection;
use yii2tool\vendor\domain\entities\TestEntity;
use yii2rails\extension\scenario\collections\ScenarioCollection;
use yii2rails\extension\scenario\helpers\ScenarioHelper;

class InitController extends \yii\base\Component
{
	
	public function init() {
		parent::init();
		Output::line();
	}

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
