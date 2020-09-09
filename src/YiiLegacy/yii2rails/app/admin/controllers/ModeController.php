<?php

namespace yii2rails\app\admin\controllers;

use Yii;
use yii2rails\domain\web\ActiveController;

class ModeController extends ActiveController
{

	const ACTION_UPDATE = 'yii2rails\app\admin\actions\UpdateAction';

	public $defaultAction = 'update';
	public $service = 'app.mode';
	public $formClass = 'yii2rails\app\admin\forms\ModeForm';

	public function actions() {
		return [
			'update' => [
				'class' => self::ACTION_UPDATE,
				'render' => self::RENDER_UPDATE,
			],
		];
	}

}
