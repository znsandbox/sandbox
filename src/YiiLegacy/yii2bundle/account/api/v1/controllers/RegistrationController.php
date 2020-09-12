<?php

namespace yii2bundle\account\api\v1\controllers;

use yii2bundle\rest\domain\rest\Controller;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

class RegistrationController extends Controller
{
	public $service = 'account.registration';
	
	public function behaviors() {
		return [
			'cors' => Behavior::cors(),
		];
	}
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'create-account' => ['POST'],
			'activate-account' => ['POST'],
			'set-password' => ['POST'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'create-account' => [
				'class' => 'yii2bundle\rest\domain\rest\UniAction',
				'successStatusCode' => 201,
				'serviceMethod' => 'createTempAccount',
				'serviceMethodParams' => ['login', 'email'],
			],
			'activate-account' => [
				'class' => 'yii2bundle\rest\domain\rest\UniAction',
				'successStatusCode' => 201,
				'serviceMethod' => 'checkActivationCode',
				'serviceMethodParams' => ['login', 'activation_code'],
			],
			'set-password' => [
				'class' => 'yii2bundle\rest\domain\rest\UniAction',
				'successStatusCode' => 201,
				'serviceMethod' => 'createTpsAccount',
				'serviceMethodParams' => ['login', 'activation_code', 'password'],
			],
		];
	}

}