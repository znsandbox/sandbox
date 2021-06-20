<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Entities;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\App\Base\BaseBundle;

class TableEntity
{

    private $name;
    private $connectionName;
    private $columns;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    public function setConnectionName(string $connectionName): void
    {
        $this->connectionName = $connectionName;
    }

    /**
     * @return Collection | ColumnEntity[]
     */
    public function getColumns(): Collection
    {
        return $this->attributes;
    }

    public function setColumns(Collection $columns): void
    {
        $this->attributes = $columns;
    }
}
