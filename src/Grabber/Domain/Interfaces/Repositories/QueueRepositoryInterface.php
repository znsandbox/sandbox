<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;

interface QueueRepositoryInterface extends CrudRepositoryInterface
{

    public function allNew(Query $query = null): Collection;

    public function allGrabed(Query $query = null): Collection;

    public function countAll(Query $query = null): int;
    public function countNew(Query $query = null): int;
    public function countGrabed(Query $query = null): int;
    public function countParsed(Query $query = null): int;
    public function lastUpdate(Query $query = null): QueueEntity;
}
