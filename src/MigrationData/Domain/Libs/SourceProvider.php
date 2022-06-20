<?php

namespace ZnSandbox\Sandbox\MigrationData\Domain\Libs;

use Illuminate\Support\Enumerable;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnCore\Base\Libs\EntityManager\Traits\EntityManagerAwareTrait;

class SourceProvider
{

    use EntityManagerAwareTrait;
    use EventDispatcherTrait;

    private $query;
    private $limit = 500;
    private $page = 1;
    private $entityClass;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->setEntityManager($em);
        $this->resetPage();
    }

    public function getQuery(): Query
    {
        if ($this->query === null) {
            $this->query = Query::forge();
        }
        return $this->query;
    }

    public function setQuery(Query $query): void
    {
        $this->query = $query;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function resetPage(): void
    {
        $this->page = 1;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    public function getCollectionByPage(int $page): Enumerable
    {
        $entityClass = $this->getEntityClass();
        $query = $this->getQuery();
        $query->page($page);
        $query->perPage($this->getLimit());
        return $this->getEntityManager()->all($entityClass, $query);
    }

    public function getNextCollection(): Enumerable
    {
        $page = $this->page;
        $collection = $this->getCollectionByPage($page);
        if ($collection->count()) {
            $this->page++;
        }
        return $collection;
    }

    public function getCount(): int
    {
        $entityClass = $this->getEntityClass();
        $query = $this->getQuery();
        return $this->getEntityManager()->count($entityClass, $query);
    }
}
