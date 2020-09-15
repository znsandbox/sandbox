<?php

namespace ZnSandbox\Sandbox\Error\Web\controllers;

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
				'class' => 'ZnSandbox\Sandbox\Error\Web\Actions\ErrorAction',
			],
		];
	}
	
}
