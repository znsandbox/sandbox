<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Repositories\Eloquent;

use App\Modules\Example\Controllers\ExampleEntity;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Database\Schema\MySqlBuilder;
use Illuminate\Database\Schema\PostgresBuilder;
use Illuminate\Support\Collection;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Db\Capsule\Manager;
use ZnLib\Db\Enums\DbDriverEnum;
use ZnLib\Fixture\Domain\Entities\FixtureEntity;
use ZnLib\Fixture\Domain\Helpers\StructHelper;
use ZnLib\Fixture\Domain\Repositories\DbRepository;
use ZnSandbox\Sandbox\Generator\Domain\Entities\ColumnEntity;
use ZnSandbox\Sandbox\Generator\Domain\Entities\TableEntity;

class SchemaRepository
{

    //private $dbRepository;
    private $capsule;

    public function __construct(Manager $capsule, DbRepository $dbRepository)
    {
        $this->capsule = $capsule;
        //$this->dbRepository = $dbRepository;
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

    public function getCapsule(): Manager
    {
        return $this->capsule;
    }

    public function getEntityClass(): string
    {
        return FixtureEntity::class;
    }

    public function allTables1(): Collection
    {
        $tableAlias = $this->getCapsule()->getAlias();
        /* @var Builder|MySqlBuilder|PostgresBuilder $schema */
        $schema = $this->getSchema();

        //dd($this->getCapsule()->getDatabaseManager());
        $dbName = $schema->getConnection()->getDatabaseName();
        $collection = new Collection;
        if($schema->getConnection()->getDriverName() == DbDriverEnum::SQLITE) {
            $array = $schema->getConnection()->getPdo()->query('SELECT name FROM sqlite_master WHERE type=\'table\'')->fetchAll(\PDO::FETCH_COLUMN);
            foreach ($array as $targetTableName) {
                $sourceTableName = $tableAlias->decode('default', $targetTableName);
                $entityClass = $this->getEntityClass();
                $entity = EntityHelper::createEntity($entityClass, [
                    'name' => $sourceTableName,
                ]);
                $collection->add($entity);
            }
        } else {
            if($schema->getConnection()->getDriverName() == DbDriverEnum::PGSQL) {
                $tableCollection = StructHelper::allPostgresTables($schema->getConnection());
            } else {
                $tableCollection = StructHelper::allTables($schema);
            }
            foreach ($tableCollection as $tableEntity) {
                $tableName = StructHelper::getTableNameFromEntity($tableEntity);
                $array[] = $tableAlias->decode('default', $tableName);
            }
            foreach ($array as $targetTableName) {
                //$key = 'Tables_in_' . $dbName;
                //$targetTableName = $item->{$key};
                $sourceTableName = $tableAlias->decode('default', $targetTableName);
                $entityClass = $this->getEntityClass();
                $entity = EntityHelper::createEntity($entityClass, [
                    'name' => $sourceTableName,
                ]);
                $collection->add($entity);
            }
        }
        return $collection;
    }

    public function allTables()
    {
        $tableCollection = $this->allTables1();
        return EntityHelper::getColumn($tableCollection, 'name');
    }

    /**
     * @param string $tableName
     * @return Collection | ColumnEntity[]
     */
    public function getColumnsByTable(string $tableName): Collection
    {
        $schema = $this->getSchema();
        $columnList = $schema->getColumnListing($tableName);
        $columnCollection = new Collection();
        foreach ($columnList as $columnName) {
            $columnType = $schema->getColumnType($tableName, $columnName);
            //$structure[$tableName][$columnName] = $columnType;
            $columnEntity = new ColumnEntity();
            $columnEntity->setName($columnName);
            $columnEntity->setType($columnType);
            $columnCollection->add($columnEntity);
        }
        return $columnCollection;
    }
}
