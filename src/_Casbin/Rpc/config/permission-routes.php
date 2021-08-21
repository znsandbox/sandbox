<?php

use ZnUser\Rbac\Rpc\Controllers\PermissionController;

return [
    [
        'method_name' => 'rbacPermission.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemAll',
        'handler_class' => PermissionController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacPermission.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemOne',
        'handler_class' => PermissionController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacPermission.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemCreate',
        'handler_class' => PermissionController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacPermission.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemUpdate',
        'handler_class' => PermissionController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacPermission.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemDelete',
        'handler_class' => PermissionController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];
