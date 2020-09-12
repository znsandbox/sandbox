<?php

namespace yii2bundle\rbac\admin;

use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;
use yii2bundle\rbac\domain\enums\RbacPermissionEnum;

class Module extends \mdm\admin\Module
{

    public $controllerNamespace = 'mdm\admin\controllers';
    public $viewPath = '//vendor/mdmsoft/yii2-admin/views';
    public $controllerMap = [
        'assignment' => [
            'class' => 'yii2bundle\rbac\admin\controllers\AssignmentController',
            'userClassName' => 'yii2bundle\account\domain\v3\models\User',
            'usernameField' => 'login',
        ],
    ];

    public function behaviors()
    {
        return [
            'access' => Behavior::access(RbacPermissionEnum::MANAGE),
        ];
    }

}
