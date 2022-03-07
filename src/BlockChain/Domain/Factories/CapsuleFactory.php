<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Factories;

use ZnDatabase\Eloquent\Domain\Capsule\Manager;
use ZnDatabase\Eloquent\Domain\Factories\ManagerFactory;

class CapsuleFactory
{

    public static function createCapsuleBySqliteFile(string $dbFile): Manager
    {
        $connections = [
            "default" => [
                "driver" => "sqlite",
                "database" => $dbFile,
            ],
        ];
        return ManagerFactory::createManagerFromConnections($connections);
    }
}
