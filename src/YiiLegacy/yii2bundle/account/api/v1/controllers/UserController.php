<?php

namespace yii2bundle\account\api\v1\controllers;

use yii2bundle\rest\domain\rest\ActiveController as Controller;

class UserController extends Controller
{

	public $service = 'account.login';

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'create' => [
				'class' => 'yii2bundle\rest\domain\rest\CreateAction',
			],
			'view' => [
				'class' => 'yii2bundle\rest\domain\rest\ViewActionWithQuery',
			],
		];
	}

}