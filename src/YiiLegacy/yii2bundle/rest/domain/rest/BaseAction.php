<?php

namespace yii2bundle\rest\domain\rest;

use Yii;
use yii\base\Action;
use yii2rails\extension\web\helpers\ControllerHelper;
use yii2rails\extension\web\traits\ActionEventTrait;

/**
 * Class BaseAction
 *
 * @package yii2bundle\rest\domain\rest
 *
 * @property \yii2bundle\rest\domain\rest\Controller $controller
 */
class BaseAction extends Action {

	use ActionEventTrait;
	
	public $service;
	public $serviceMethod;
	public $serviceMethodParams = [];
	public $successStatusCode = 200;

	public function behaviors() {
		return $this->controller->behaviors();
	}
	
	public function init() {
		parent::init();
		$this->service = ControllerHelper::forgeService($this->getService());
	}

    protected function runServiceMethod1() {
        $args = func_get_args();
        $response = ControllerHelper::runServiceMethod($this->service, $this->serviceMethod, $args, $this->serviceMethodParams);

        Yii::$app->response->setStatusCode($this->successStatusCode);
        /*if($this->successStatusCode != 200) {
            $response = null;
        }*/
        return $response;
    }

	protected function runServiceMethod() {
		$args = func_get_args();
		$response = ControllerHelper::runServiceMethod($this->service, $this->serviceMethod, $args, $this->serviceMethodParams);
		
		Yii::$app->response->setStatusCode($this->successStatusCode);
		if($this->successStatusCode != 200) {
		    $this->beforeResponseClear($response);
			$response = null;
		}
		return $response;
	}

	protected function beforeResponseClear($response){}

    private function getService() {
		if(!empty($this->service)) {
			return $this->service;
		}
		return $this->service = $this->controller->service;
	}

}
