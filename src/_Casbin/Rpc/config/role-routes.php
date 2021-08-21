<?php

use ZnUser\Rbac\Domain\Enums\Rbac\RbacItemEnum;
use ZnUser\Rbac\Rpc\Controllers\RoleController;

return [
    [
        'method_name' => 'rbacRole.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => RbacItemEnum::ALL,
        'handler_class' => RoleController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacRole.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemOne',
        'handler_class' => RoleController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacRole.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemCreate',
        'handler_class' => RoleController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacRole.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemUpdate',
        'handler_class' => RoleController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacRole.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemDelete',
        'handler_class' => RoleController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];
