<?php

use ZnSandbox\Sandbox\Person2\Domain\Enums\Rbac\MyChildPermissionEnum;
use ZnSandbox\Sandbox\Person2\Rpc\Controllers\MyChildController;

return [
    [
        'method_name' => 'myChild.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyChildPermissionEnum::ALL,
        'handler_class' => MyChildController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myChild.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyChildPermissionEnum::ONE,
        'handler_class' => MyChildController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myChild.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyChildPermissionEnum::CREATE,
        'handler_class' => MyChildController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myChild.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyChildPermissionEnum::UPDATE,
        'handler_class' => MyChildController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myChild.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyChildPermissionEnum::DELETE,
        'handler_class' => MyChildController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];