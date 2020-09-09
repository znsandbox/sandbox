<?php

namespace yii2bundle\rbac\admin\helpers;

use yii2rails\extension\web\helpers\Behavior;
use yii2bundle\rbac\domain\enums\RbacPermissionEnum;

class ModuleHelper {
	
	public static function config() {
		return [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'yii2bundle\rbac\admin\controllers\AssignmentController',
                    'userClassName' => 'yii2bundle\account\domain\v3\models\User',
                    'usernameField' => 'login',
                ],
            ],
            'as access' => Behavior::access(RbacPermissionEnum::MANAGE),
        ];
	}
	
}
