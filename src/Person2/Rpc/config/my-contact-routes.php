<?php

use ZnSandbox\Sandbox\Person2\Domain\Enums\Rbac\MyContactPermissionEnum;
use ZnSandbox\Sandbox\Person2\Rpc\Controllers\MyContactController;

return [
    [
        'method_name' => 'myContact.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyContactPermissionEnum::ALL,
        'handler_class' => MyContactController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myContact.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyContactPermissionEnum::ONE,
        'handler_class' => MyContactController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myContact.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyContactPermissionEnum::CREATE,
        'handler_class' => MyContactController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myContact.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyContactPermissionEnum::UPDATE,
        'handler_class' => MyContactController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'myContact.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => MyContactPermissionEnum::DELETE,
        'handler_class' => MyContactController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];