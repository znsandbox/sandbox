<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Repositories\Eloquent;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Support\Collection;
use ZnLib\Db\Capsule\Manager;
use ZnLib\Db\Enums\DbDriverEnum;
use ZnSandbox\Sandbox\Generator\Domain\Entities\ColumnEntity;
use ZnSandbox\Sandbox\Generator\Domain\Entities\TableEntity;

class SchemaRepository
{

    private $capsule;
    private $dbRepository;

    public function __construct(Manager $capsule)
    {
        $this->capsule = $capsule;
        $driver = $this->getConnection()->getDriverName();
        if ($driver == DbDriverEnum::SQLITE) {
            $this->dbRepository = new \ZnSandbox\Sandbox\Generator\Domain\Repositories\Sqlite\DbRepository($capsule);
        } elseif ($driver == DbDriverEnum::PGSQL) {
            $this->dbRepository = new \ZnSandbox\Sandbox\Generator\Domain\Repositories\Postgres\DbRepository($capsule);
        } else {
            $this->dbRepository = new \ZnSandbox\Sandbox\Generator\Domain\Repositories\Mysql\DbRepository($capsule);
        }
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

    /*protected function getSchema(): SchemaBuilder
    {
        $connection = $this->getConnection();
        $schema = $connection->getSchemaBuilder();
        return $schema;
    }

    public function getCapsule(): Manager
    {
        return $this->capsule;
    }*/

    public function allTablesByName(array $nameList): Collection
    {
        /** @var TableEntity[] $collection */
        $collection = $this->allTables();
        $newCollection = new Collection();
        foreach ($collection as $tableEntity) {
            if (in_array($tableEntity->getName(), $nameList)) {
                $columnCollection = $this->dbRepository->allColumnsByTable($tableEntity->getName(), $tableEntity->getSchemaName());
                $tableEntity->setColumns($columnCollection);
                $relationCollection = $this->dbRepository->allRelations($tableEntity->getName());
                $tableEntity->setRelations($relationCollection);
                $newCollection->add($tableEntity);
            }
        }
        return $newCollection;
    }

    public function allTables(): Collection
    {
        return $this->dbRepository->allTables();
    }
}
