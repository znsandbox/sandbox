<?php

use ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac\GeoRegionPermissionEnum;
use ZnSandbox\Sandbox\Geo\Rpc\Controllers\RegionController;

return [
    [
        'method_name' => 'geoRegion.all',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoRegionPermissionEnum::ALL,
        'handler_class' => RegionController::class,
        'handler_method' => 'all',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoRegion.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoRegionPermissionEnum::ONE,
        'handler_class' => RegionController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoRegion.create',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoRegionPermissionEnum::CREATE,
        'handler_class' => RegionController::class,
        'handler_method' => 'add',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoRegion.update',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoRegionPermissionEnum::UPDATE,
        'handler_class' => RegionController::class,
        'handler_method' => 'update',
        'status_id' => 100,
    ],
    [
        'method_name' => 'geoRegion.delete',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => GeoRegionPermissionEnum::DELETE,
        'handler_class' => RegionController::class,
        'handler_method' => 'delete',
        'status_id' => 100,
    ],
];