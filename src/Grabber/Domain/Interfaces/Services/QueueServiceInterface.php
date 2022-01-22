<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Grabber\Domain\Dto\TotalDto;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;

interface QueueServiceInterface extends CrudServiceInterface
{

    public function total(): TotalDto;

    public function parseOne(QueueEntity $queueEntity);

    public function runOne(QueueEntity $queueEntity);

    public function allNew(): Collection;

    public function allGrabed(): Collection;

    public function lastUpdateTime(Query $query = null): \DateTime;
}

