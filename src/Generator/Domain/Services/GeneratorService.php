<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnDatabase\Base\Domain\Entities\TableEntity;
use ZnDatabase\Base\Domain\Repositories\Eloquent\SchemaRepository;

class GeneratorService
{

    private $schemaRepository;

    public function __construct(SchemaRepository $schemaRepository)
    {
        $this->schemaRepository = $schemaRepository;
    }

    public function allTables()
    {
        $tableCollection = $this->schemaRepository->allTables();
        return EntityHelper::getColumn($tableCollection, 'name');
    }

    /**
     * @param $tableList
     * @return Collection | TableEntity[]
     */
    public function getStructure(array $tableList): Collection
    {
        $tableCollection = $this->schemaRepository->allTablesByName($tableList);
        return $tableCollection;

        /*$tableCollection = new Collection();
        foreach ($tableList as $tableName) {
            $columnCollection = $this->schemaRepository->getColumnsByTable($tableName);
            $tableEntity = new TableEntity();
            $tableEntity->setConnectionName('default');
            $tableEntity->setName($tableName);
            $tableEntity->setColumns($columnCollection);
            $tableCollection->add($tableEntity);
        }
        return $tableCollection;*/
    }
}
