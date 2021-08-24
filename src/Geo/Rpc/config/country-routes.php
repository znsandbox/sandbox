<?php

use ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac\GeoCountryPermissionEnum;
use ZnSandbox\Sandbox\Geo\Rpc\Controllers\CountryController;

return [
    [
        'method_name' => 'geoCountry.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCountryPermissionEnum::ALL,
        'handler_class' => CountryController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCountry.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCountryPermissionEnum::ONE,
        'handler_class' => CountryController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCountry.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCountryPermissionEnum::CREATE,
        'handler_class' => CountryController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCountry.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCountryPermissionEnum::UPDATE,
        'handler_class' => CountryController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoCountry.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoCountryPermissionEnum::DELETE,
        'handler_class' => CountryController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];