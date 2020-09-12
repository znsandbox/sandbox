<?php

namespace yii2bundle\lang\module\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

class DefaultController extends Controller
{
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verb' => Behavior::verb([
				'change' => ['post'],
			]),
		];
	}

	function actionChange($language) {
		$request = Yii::$app->request;
		if(!empty($language)) {
			\App::$domain->lang->language->saveCurrent($language);
			return $this->redirect($request->referrer);
		}
	}
	
}
