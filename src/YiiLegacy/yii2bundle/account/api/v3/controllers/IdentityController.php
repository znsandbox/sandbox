<?php

namespace yii2bundle\account\api\v3\controllers;

use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use yii2bundle\applicationTemplate\common\enums\ApplicationPermissionEnum;
use yii2rails\extension\web\helpers\Behavior;
use yii2bundle\rest\domain\rest\ActiveControllerWithQuery as Controller;

class IdentityController extends Controller
{

	public $service = 'account.identity';

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'cors' => Behavior::cors(),
			'authenticator' => Behavior::auth(),
            'access' => Behavior::access(AccountPermissionEnum::IDENTITY_READ),
		];
	}

}