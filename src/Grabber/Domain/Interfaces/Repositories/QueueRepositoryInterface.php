<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface QueueRepositoryInterface extends CrudRepositoryInterface
{

    public function allNew(): Collection;

    public function allGrabed(): Collection;
}
