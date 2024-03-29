<?php

use ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac\GeoCurrencyPermissionEnum;
use ZnSandbox\Sandbox\Geo\Rpc\Controllers\CurrencyController;

return [
    [
        'method_name' => 'geoCurrency.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCurrencyPermissionEnum::ALL,
        'handler_class' => CurrencyController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCurrency.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCurrencyPermissionEnum::ONE,
        'handler_class' => CurrencyController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCurrency.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCurrencyPermissionEnum::CREATE,
        'handler_class' => CurrencyController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCurrency.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCurrencyPermissionEnum::UPDATE,
        'handler_class' => CurrencyController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCurrency.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCurrencyPermissionEnum::DELETE,
        'handler_class' => CurrencyController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];