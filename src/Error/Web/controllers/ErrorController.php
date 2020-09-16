<?php

namespace ZnSandbox\Sandbox\Error\Web\controllers;

use yii\web\Controller;

class ErrorController extends Controller
{

	public function actions()
	{
		return [
			'error' => [
				'class' => 'ZnSandbox\Sandbox\Error\Web\Actions\ErrorAction',
			],
		];
	}
}
