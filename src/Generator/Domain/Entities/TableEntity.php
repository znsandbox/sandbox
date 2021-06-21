<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Entities;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\App\Base\BaseBundle;

class TableEntity
{

    private $name;
    private $schemaName;
    private $dbName;
    private $columns;
    private $relations;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSchemaName()
    {
        return $this->schemaName;
    }

    public function setSchemaName($schemaName): void
    {
        $this->schemaName = $schemaName;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    public function setDbName($dbName): void
    {
        $this->dbName = $dbName;
    }

    /**
     * @return Collection | ColumnEntity[]
     */
    public function getColumns(): Collection
    {
        return $this->columns;
    }

    public function setColumns(Collection $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return Collection | RelationEntity[]
     */
    public function getRelations(): Collection
    {
        return $this->relations;
    }

    public function setRelations(Collection $relations): void
    {
        $this->relations = $relations;
    }
}
