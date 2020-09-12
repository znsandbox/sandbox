<?php

namespace yii2bundle\rbac\console\controllers;

use Yii;
use yii\web\UnauthorizedHttpException;
use yii2rails\extension\console\base\Controller;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

class RoleController extends Controller
{
	
	public function behaviors()
	{
		return [
			'authenticator' => Behavior::auth(),
		];
	}
	/**
	 * Search and add RBAC rules
	 */
	public function actionUpdate()
	{
		try{
			\App::$domain->rbac->role->updateAll();
		}catch(UnauthorizedHttpException $e){
			Yii::$app->cache->set('identity', null);
			\App::$domain->account->auth->breakSession();
		}
		echo 'success';
	}

	
}
