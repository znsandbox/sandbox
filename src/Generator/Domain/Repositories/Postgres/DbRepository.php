<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Repositories\Postgres;

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

class DbRepository extends \ZnSandbox\Sandbox\Generator\Domain\Repositories\Base\DbRepository
{

    public function allTables(): Collection
    {
        $connection = $this->getConnection();
        $schemaCollection = $this->allSchemas();
        $tableCollection = new Collection;
        foreach ($schemaCollection as $schemaEntity) {
            $tables = $connection->select("SELECT * FROM information_schema.tables WHERE table_schema = '{$schemaEntity->getName()}'");
            $tableNames = ArrayHelper::getColumn($tables, 'table_name');
            foreach ($tableNames as $tableName) {
                // $tableName = StructHelper::getTableNameFromEntity($tableEntity);
                $tableEntity = new TableEntity();
                $tableEntity->setName($tableName);
                $tableEntity->setSchemaName($schemaEntity->getName());
                $tableEntity->setDbName($schemaEntity->getDbName());
                $tableCollection->add($tableEntity);
            }
        }
        return $tableCollection;
    }

    public function allRelations(string $tableName): Collection
    {
        $sql = "SELECT
tc.constraint_name, tc.table_name, kcu.column_name, 
ccu.table_name AS foreign_table_name,
ccu.column_name AS foreign_column_name 
FROM 
information_schema.table_constraints AS tc 
JOIN information_schema.key_column_usage AS kcu
  ON tc.constraint_name = kcu.constraint_name
JOIN information_schema.constraint_column_usage AS ccu
  ON ccu.constraint_name = tc.constraint_name
WHERE constraint_type = 'FOREIGN KEY' AND tc.table_name='$tableName';";
        $array = $this->getConnection()->select($sql);
        $collection = new Collection();
        foreach ($array as $item) {
            $relationEntity = new RelationEntity();
            $relationEntity->setConstraintName($item->constraint_name);
            $relationEntity->setTableName($item->table_name);
            $relationEntity->setColumnName($item->column_name);
            $relationEntity->setForeignTableName($item->foreign_table_name);
            $relationEntity->setForeignColumnName($item->foreign_column_name);
            $collection->add($relationEntity);
        }
        return $collection;
    }

    /**
     * @param ConnectionInterface $connection
     * @return Collection | SchemaEntity[]
     */
    private function allSchemas(): Collection
    {
        $connection = $this->getConnection();
        $schemaCollection = $connection->select("select schema_name from information_schema.schemata;");
        $schemaNames = ArrayHelper::getColumn($schemaCollection, 'schema_name');
        $excludes = [
            "pg_toast",
            "pg_temp_1",
            "pg_toast_temp_1",
            "pg_catalog",
            "information_schema",
        ];
        $schemaNames = array_diff($schemaNames, $excludes);
        /** @var SchemaEntity[] | Collection $collection */
        $collection = new Collection;
        foreach ($schemaNames as $schemaName) {
            $entity = new SchemaEntity;
            $entity->setName($schemaName);
            $entity->setDbName($connection->getConfig('database'));
            $collection->add($entity);
        }
        return $collection;
    }

}
