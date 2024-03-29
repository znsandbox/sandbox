<?php

use ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac\GeoLocalityPermissionEnum;
use ZnSandbox\Sandbox\Geo\Rpc\Controllers\LocalityController;

return [
    [
        'method_name' => 'geoLocality.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoLocalityPermissionEnum::ALL,
        'handler_class' => LocalityController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoLocality.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoLocalityPermissionEnum::ONE,
        'handler_class' => LocalityController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoLocality.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoLocalityPermissionEnum::CREATE,
        'handler_class' => LocalityController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoLocality.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoLocalityPermissionEnum::UPDATE,
        'handler_class' => LocalityController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoLocality.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoLocalityPermissionEnum::DELETE,
        'handler_class' => LocalityController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];