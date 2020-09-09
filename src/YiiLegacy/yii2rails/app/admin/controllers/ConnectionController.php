<?php

namespace yii2rails\app\admin\controllers;

use Yii;
use yii2rails\domain\web\ActiveController;

class ConnectionController extends ActiveController
{

	const ACTION_UPDATE = 'yii2rails\app\admin\actions\UpdateAction';

	public $defaultAction = 'main';
	public $service = 'app.connection';
	public $formClass = 'yii2rails\app\admin\forms\ConnectionForm';

	public function actions() {
		return [
			'main' => [
				'class' => self::ACTION_UPDATE,
				'render' => self::RENDER_UPDATE,
			],
			'test' => [
				'class' => self::ACTION_UPDATE,
				'render' => self::RENDER_UPDATE,
			],
		];
	}

}
