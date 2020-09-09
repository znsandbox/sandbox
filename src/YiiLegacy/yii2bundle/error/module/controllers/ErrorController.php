<?php

namespace yii2bundle\error\module\controllers;

use yii\web\Controller;

/**
 * Error controller
 */
class ErrorController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii2bundle\error\module\actions\ErrorAction',
			],
		];
	}
	
}
