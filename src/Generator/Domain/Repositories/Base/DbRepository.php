<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Repositories\Base;

use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Support\Collection;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Db\Capsule\Manager;
use ZnDatabase\Base\Domain\Entities\SchemaEntity;
use ZnDatabase\Eloquent\Domain\Traits\EloquentTrait;
use ZnDatabase\Base\Domain\Entities\ColumnEntity;
use ZnDatabase\Base\Domain\Entities\RelationEntity;
use ZnDatabase\Base\Domain\Entities\TableEntity;

DeprecateHelper::softThrow();

/**
 * @deprecated
 */
abstract class DbRepository
{

    use EloquentTrait;

//    private $capsule;

    public function __construct(Manager $capsule)
    {
        $this->setCapsule($capsule);
    }

    public function connectionName()
    {
        return 'default';
    }

    /*public function getConnection(): Connection
    {
        $connection = $this->capsule->getConnection($this->connectionName());
        return $connection;
    }*/

    /*protected function getSchema(): SchemaBuilder
    {
        $connection = $this->getConnection();
        $schema = $connection->getSchemaBuilder();
        return $schema;
    }*/

    /*public function getCapsule(): Manager
    {
        return $this->capsule;
    }*/

    /**
     * @param string $tableName
     * @param string $schemaName
     * @return Collection | ColumnEntity[]
     */
    public function allColumnsByTable(string $tableName, string $schemaName = 'public'): Collection
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
