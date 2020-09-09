<?php

namespace yii2bundle\geo\api\controllers;

use yii2bundle\geo\domain\enums\GeoPermissionEnum;
use yii2bundle\rest\domain\rest\ActiveControllerWithQuery as Controller;
use yii2rails\extension\web\helpers\Behavior;

class CityController extends Controller
{
	
	public $service = 'geo.city';

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
            'cors' => Behavior::cors(),
		    'authenticator' => Behavior::auth(['create', 'update', 'delete']),
            'access' => Behavior::access(GeoPermissionEnum::CITY_MANAGE, ['create', 'update', 'delete']),
		];
	}
	
}
