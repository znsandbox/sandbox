<?php

namespace yii2bundle\rest\domain\rest;

use Yii;
use yii2rails\extension\web\enums\ActionEventEnum;
use yii2rails\extension\web\helpers\ControllerHelper;

class IndexAction extends BaseAction {

	public $serviceMethod = 'getDataProvider';
	
	public function run() {
		//ControllerHelper::beforeReadTrigger($this);
		//$body = $this->callActionTrigger(ActionEventEnum::BEFORE_WRITE, $body);
		$params = Yii::$app->request->get();
		return $this->runServiceMethod($params);
	}

}
