<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Repositories\Base;

use App\Modules\Example\Controllers\ExampleEntity;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Support\Collection;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnLib\Db\Capsule\Manager;
use ZnLib\Db\Entities\SchemaEntity;
use ZnSandbox\Sandbox\Generator\Domain\Entities\ColumnEntity;
use ZnSandbox\Sandbox\Generator\Domain\Entities\RelationEntity;
use ZnSandbox\Sandbox\Generator\Domain\Entities\TableEntity;

class DbRepository
{

    private $capsule;

    public function __construct(Manager $capsule)
    {
        $this->capsule = $capsule;
    }

    public function connectionName()
    {
        return 'default';
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

    /*public function getCapsule(): Manager
    {
        return $this->capsule;
    }*/

    /**
     * @param string $tableName
     * @return Collection | ColumnEntity[]
     */
    public function allColumnsByTable(string $tableName): Collection
    {
        $schema = $this->getSchema();
        $columnList = $schema->getColumnListing($tableName);
        $columnCollection = new Collection();
        foreach ($columnList as $columnName) {
            $columnType = $schema->getColumnType($tableName, $columnName);
            $columnEntity = new ColumnEntity();
            $columnEntity->setName($columnName);
            $columnEntity->setType($columnType);
            $columnCollection->add($columnEntity);
        }
        return $columnCollection;
    }

}
