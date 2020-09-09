<?php

namespace yii2rails\app\admin\controllers;

use Yii;
use yii2rails\domain\web\ActiveController;

class RemoteController extends ActiveController
{

	const ACTION_UPDATE = 'yii2rails\app\admin\actions\UpdateAction';

	public $defaultAction = 'update';
	public $service = 'app.remote';
	public $formClass = 'yii2rails\app\admin\forms\RemoteForm';

	public function actions() {
		return [
			'update' => [
				'class' => self::ACTION_UPDATE,
				'render' => self::RENDER_UPDATE,
			],
		];
	}

}
