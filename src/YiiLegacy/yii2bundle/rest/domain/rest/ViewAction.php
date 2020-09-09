<?php

namespace yii2bundle\rest\domain\rest;

use Yii;
use yii2rails\extension\web\enums\ActionEventEnum;

class ViewAction extends BaseAction {

	public $serviceMethod = 'findOne';
	
	public function run($id) {
		$this->callActionTrigger(ActionEventEnum::BEFORE_READ);
		$params = Yii::$app->request->get();
		$response = $this->runServiceMethod($id, $params);
		$response = $this->callActionTrigger(ActionEventEnum::AFTER_READ, $response);
		return $response;
	}
}
