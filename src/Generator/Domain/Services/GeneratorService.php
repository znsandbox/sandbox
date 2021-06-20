<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Services;

use App\Modules\Example\Controllers\ExampleEntity;
use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\Generator\Domain\Entities\TableEntity;
use ZnSandbox\Sandbox\Generator\Domain\Repositories\Eloquent\SchemaRepository;

class GeneratorService
{

    private $schemaRepository;

    public function __construct(SchemaRepository $schemaRepository)
    {
        $this->schemaRepository = $schemaRepository;
    }

    public function allTables()
    {
        return $this->schemaRepository->allTables();
    }

    /**
     * @param $tableList
     * @return Collection | TableEntity[]
     */
    public function getStructure(array $tableList): Collection
    {
        $tableCollection = new Collection();
        foreach ($tableList as $tableName) {
            $columnCollection = $this->schemaRepository->getColumnsByTable($tableName);
            $tableEntity = new TableEntity();
            $tableEntity->setConnectionName('default');
            $tableEntity->setName($tableName);
            $tableEntity->setColumns($columnCollection);
            $tableCollection->add($tableEntity);
        }
        return $tableCollection;
    }
}
