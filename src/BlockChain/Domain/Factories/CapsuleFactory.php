<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Factories;

use ZnLib\Db\Capsule\Manager;
use ZnLib\Db\Factories\ManagerFactory;

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
