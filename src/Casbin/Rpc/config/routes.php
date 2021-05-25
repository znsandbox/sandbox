<?php

use ZnSandbox\Sandbox\Casbin\Domain\Enums\Rbac\RbacItemEnum;
use ZnSandbox\Sandbox\Casbin\Rpc\Controllers\RoleController;

return [
   /* [
        'method_name' => 'rbacItem.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemAll',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\ItemController',
        'handler_method' => 'all',
        'status_id' => 100,
    ],*/

    [
        'method_name' => 'rbacAssignment.attach',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => \ZnSandbox\Sandbox\Casbin\Domain\Enums\Rbac\RbacAssignmentEnum::ATTACH,
        'handler_class' => \ZnSandbox\Sandbox\Casbin\Rpc\Controllers\AssignmentController::class,
        'handler_method' => 'attach',
        'status_id' => 100,
    ],
    [
        'method_name' => 'rbacAssignment.detach',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => \ZnSandbox\Sandbox\Casbin\Domain\Enums\Rbac\RbacAssignmentEnum::DETACH,
        'handler_class' => \ZnSandbox\Sandbox\Casbin\Rpc\Controllers\AssignmentController::class,
        'handler_method' => 'detach',
        'status_id' => 100,
    ],



    [
        'method_name' => 'role.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => RbacItemEnum::ALL,
        'handler_class' => RoleController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'role.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemOne',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\RoleController',
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'role.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemCreate',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\RoleController',
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'role.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemUpdate',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\RoleController',
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'role.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemDelete',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\RoleController',
        'handler_method' => 'delete',
        'status_id' => 100,
    ],

    // permission

    [
        'method_name' => 'permission.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemAll',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\PermissionController',
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'permission.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemOne',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\PermissionController',
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'permission.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemCreate',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\PermissionController',
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'permission.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemUpdate',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\PermissionController',
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'permission.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => 'oRbacItemDelete',
        'handler_class' => 'ZnSandbox\Sandbox\Casbin\Rpc\Controllers\PermissionController',
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];