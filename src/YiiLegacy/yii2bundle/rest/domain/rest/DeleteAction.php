<?php

namespace yii2bundle\rest\domain\rest;

use yii2rails\extension\web\enums\ActionEventEnum;

class DeleteAction extends BaseAction {

	public $serviceMethod = 'delete';
	public $successStatusCode = 204;
	
	public function run($id) {
		$this->callActionTrigger(ActionEventEnum::BEFORE_DELETE);
		$response = $this->runServiceMethod($id);
		$response = $this->callActionTrigger(ActionEventEnum::AFTER_DELETE, $response);
		return $response;
	}
}
