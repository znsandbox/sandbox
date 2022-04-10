<?php

use ZnSandbox\Sandbox\BlockChain\Rpc\Controllers\DocumentController;

return [
    [
        'method_name' => 'crypto.send',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => \ZnSandbox\Sandbox\BlockChain\Domain\Enums\Rbac\BlockchainDocumentPermissionEnum::CREATE,
        'handler_class' => DocumentController::class,
        'handler_method' => 'send',
        'status_id' => 100,
    ],
    [
        'method_name' => 'cryptoMessage.p2p',
        'version' => '1',
        'is_verify_eds' => false,
        'is_verify_auth' => false,
        'permission_name' => \ZnSandbox\Sandbox\BlockChain\Domain\Enums\Rbac\BlockchainDocumentPermissionEnum::CREATE,
        'handler_class' => DocumentController::class,
        'handler_method' => 'p2p',
        'status_id' => 100,
    ],
];