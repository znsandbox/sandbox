<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;

interface QueueServiceInterface extends CrudServiceInterface
{

    public function parseOne(QueueEntity $queueEntity);

    public function runOne(QueueEntity $queueEntity);

    public function allNew(): Collection;

    public function allGrabed(): Collection;
}

