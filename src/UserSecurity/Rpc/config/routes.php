<?php

use ZnSandbox\Sandbox\UserSecurity\Domain\Enums\Rbac\SecurityPermissionEnum;
use ZnSandbox\Sandbox\UserSecurity\Rpc\Controllers\RestorePasswordController;
use ZnSandbox\Sandbox\UserSecurity\Rpc\Controllers\UpdatePasswordController;

return [
    [
        'method_name' => 'restorePassword.requestActivationCode',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => SecurityPermissionEnum::RESTORE_PASSWORD_REQUEST_ACTIVATION_CODE,
        'handler_class' => RestorePasswordController::class,
        'handler_method' => 'requestActivationCode',
        'status_id' => 100,
    ],
    [
        'method_name' => 'restorePassword.createPassword',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => SecurityPermissionEnum::RESTORE_PASSWORD_CREATE_PASSWORD,
        'handler_class' => RestorePasswordController::class,
        'handler_method' => 'createPassword',
        'status_id' => 100,
    ],
    [
        'method_name' => 'updatePassword.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => SecurityPermissionEnum::UPDATE_PASSWORD_UPDATE,
        'handler_class' => UpdatePasswordController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
];
