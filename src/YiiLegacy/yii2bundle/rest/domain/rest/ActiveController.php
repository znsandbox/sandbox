<?php

namespace yii2bundle\rest\domain\rest;

use Yii;

class ActiveController extends Controller {

    public $formClass = null;
    public $titleName = null;

	public function actions() {
		return [
			'index' => [
				'class' => 'yii2bundle\rest\domain\rest\IndexAction',
				'serviceMethod' => 'getDataProvider',
			],
			'create' => [
				'class' => 'yii2bundle\rest\domain\rest\CreateAction',
			],
			'view' => [
				'class' => 'yii2bundle\rest\domain\rest\ViewAction',
			],
			'update' => [
				'class' => 'yii2bundle\rest\domain\rest\UpdateAction',
			],
			'delete' => [
				'class' => 'yii2bundle\rest\domain\rest\DeleteAction',
			],
		];
	}
	
	protected function verbs() {
		return [
			'index' => ['GET', 'HEAD'],
			'view' => ['GET', 'HEAD'],
			'create' => ['POST'],
			'update' => ['PUT', 'PATCH'],
			'delete' => ['DELETE'],
			'options' => ['OPTIONS'],
		];
	}
	
	public function actionOptions() {
		if(Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
			Yii::$app->getResponse()->setStatusCode(405);
		}
		//Yii::$app->getResponse()->getHeaders()->set('Allow',['DELETE']);
	}
}
