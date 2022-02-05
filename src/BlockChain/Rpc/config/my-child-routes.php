<?php

use ZnSandbox\Sandbox\BlockChain\Rpc\Controllers\DocumentController;

return [
    [
        'method_name' => 'crypto.send',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => true,
        'permission_name' => \ZnUser\Rbac\Domain\Enums\Rbac\SystemRoleEnum::GUEST,
        'handler_class' => DocumentController::class,
        'handler_method' => 'send',
        'status_id' => 100,
    ],
];