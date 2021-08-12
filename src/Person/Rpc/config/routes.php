<?php

use ZnSandbox\Sandbox\Person\Domain\Enums\Rbac\AppPersonPermissionEnum;
use ZnSandbox\Sandbox\Person\Rpc\Controllers\PersonController;

return [
    [
        'method_name' => 'personInfo.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'personContact.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'personAddress.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'personIdentityCard.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'personBirthCertificate.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
    [
        'method_name' => 'personPassport.oneById',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => AppPersonPermissionEnum::PERSON_INFO_ONE,
        'handler_class' => PersonController::class,
        'handler_method' => 'oneById',
        'status_id' => 100,
    ],
];