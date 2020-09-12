<?php

namespace yii2bundle\account\api\v1\controllers;

use yii2bundle\rest\domain\rest\Controller;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

class BalanceController extends Controller
{

	public $service = 'account.balance';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => Behavior::auth(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'index' => [
				'class' => 'yii2bundle\rest\domain\rest\IndexActionWithQuery',
				'serviceMethod' => 'oneSelf',
			],
		];
	}
	
}