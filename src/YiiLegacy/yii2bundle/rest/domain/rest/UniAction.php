<?php

namespace yii2bundle\rest\domain\rest;

use Yii;

class UniAction extends BaseAction {

	public $serviceMethod = 'update';
	
	public function run() {
		$body = Yii::$app->request->getBodyParams();
		//$body = $this->callActionTrigger(ActionEventEnum::BEFORE_WRITE, $body);
		$response = $this->runServiceMethod($body);
		return $this->responseToArray($response);
	}
	
	protected function responseToArray($response) {
		$response = !empty($response) ? $response : [];
		return $response;
	}

}
