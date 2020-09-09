<?php

namespace yii2bundle\account\api\v3\controllers;

use yii2bundle\rest\domain\rest\Controller;
use yii2rails\extension\web\helpers\Behavior;

class SecurityController extends Controller
{

	public $service = 'account.security';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => Behavior::auth(),
			'verb' => Behavior::verb([
				'email' => ['PUT'],
				'password' => ['PUT'],
			]),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		$actions = parent::actions();
		$actions['email'] = [
			'class' => 'yii2bundle\rest\domain\rest\UniAction',
			'successStatusCode' => 204,
			'serviceMethod' => 'changeEmail',
		];
		$actions['password'] = [
			'class' => 'yii2bundle\rest\domain\rest\UniAction',
			'successStatusCode' => 204,
			'serviceMethod' => 'changePassword',
		];
		return $actions;
	}

}