<?php

namespace tests\functional\connetcion;

use yii2bundle\db\domain\helpers\ConnectionFactoryHelper;
use yii2bundle\db\domain\helpers\ConnectionContainer;
use yii2rails\extension\psr\cache\InvalidArgumentException;
use yii2rails\extension\psr\cache\Cache;
use yii2rails\extension\psr\cache\CacheItem;
use yii2rails\extension\psr\container\Container;
use yii2rails\extension\encrypt\exceptions\SignatureInvalidException;
use yii2rails\extension\encrypt\libs\JwtService;
use yii2tool\test\Test\Unit;

class ConnectionTest extends Unit {
	
	const PACKAGE = 'yii2bundle/yii2-db';

    public function testRead() {
        $configDb = [
            'driver' => 'sqlite',
            'dbname' => __DIR__ . '\..\..\_data\sqlite\main.db',
        ];
        $connection = ConnectionFactoryHelper::createConnectionFromConfig($configDb);
        $query = 'SELECT * FROM "migration" LIMIT 50';
        $results =  $connection->createCommand($query)->queryAll();
        $this->tester->assertCount(43, $results);
    }

    public function testRead2() {
        $definitions = [
            'db' => [
                'class' => ConnectionContainer::class,
                'connections' => [
                    'main' => [
                        'driver' => 'sqlite',
                        'dbname' => __DIR__ . '\..\..\_data\sqlite\main.db',
                    ],
                    'slave' => [
                        'driver' => 'sqlite',
                        'dbname' => __DIR__ . '\..\..\_data\sqlite\main.db',
                    ],
                ],
            ],
        ];

        $container = new Container($definitions);
        $mainConnection = $container->db->get('main');
        $slaveConnection = $container->db->get('slave');

        $query = 'SELECT * FROM "migration" LIMIT 50';

        $results =  $slaveConnection->createCommand($query)->queryAll();
        $this->tester->assertCount(43, $results);
    }

}
