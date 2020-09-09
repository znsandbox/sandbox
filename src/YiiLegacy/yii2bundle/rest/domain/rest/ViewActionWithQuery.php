<?php

namespace yii2bundle\rest\domain\rest;

use Yii;
use yii2rails\extension\web\enums\ActionEventEnum;
use yii2rails\extension\web\helpers\ClientHelper;

class ViewActionWithQuery extends BaseAction {

	public $serviceMethod = 'oneById';
	public $query = null;
	
	public function run($id) {
		$this->callActionTrigger(ActionEventEnum::BEFORE_READ);
		$queryParams = Yii::$app->request->get();
		unset($queryParams['id']);
		$query = ClientHelper::getQueryFromRequest($queryParams, $this->query);
		$response = $this->runServiceMethod($id, $query);
		$response = $this->callActionTrigger(ActionEventEnum::AFTER_READ, $response);
		return $response;
	}

}
