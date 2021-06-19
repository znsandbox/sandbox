<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Services;

use App\Modules\Example\Controllers\ExampleEntity;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnLib\Db\Capsule\Manager;
use ZnLib\Fixture\Domain\Entities\FixtureEntity;
use ZnLib\Fixture\Domain\Repositories\DbRepository;

class GeneratorService
{

    private $dbRepository;
    private $capsule;

    public function __construct(Manager $capsule, DbRepository $dbRepository)
    {
        $this->capsule = $capsule;
        $this->dbRepository = $dbRepository;
    }

    public function connectionName()
    {
        return 'default';
        //return $this->capsule->getConnectionNameByTableName($this->tableName());
    }

    public function getConnection(): Connection
    {
        $connection = $this->capsule->getConnection($this->connectionName());
        return $connection;
    }

    protected function getSchema(): SchemaBuilder
    {
        $connection = $this->getConnection();
        $schema = $connection->getSchemaBuilder();
        return $schema;
    }

    public function allTables() {
        $tableCollection = $this->dbRepository->allTables();
        return EntityHelper::getColumn($tableCollection, 'name');
    }

    public function getStructure($tableList) {
        $schema = $this->getSchema();
        $structure = [];
        foreach ($tableList as $tableName) {
            $columnList = $schema->getColumnListing($tableName);
            foreach ($columnList as $columnName) {
                $columnType = $schema->getColumnType($tableName, $columnName);
                $structure[$tableName][$columnName] = $columnType;
            }
        }
        return $structure;
    }
}
