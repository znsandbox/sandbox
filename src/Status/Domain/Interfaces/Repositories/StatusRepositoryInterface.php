<?php

namespace ZnSandbox\Sandbox\Status\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Interfaces\ReadAllInterface;
use ZnCore\Repository\Interfaces\FindOneInterface;
use ZnCore\Repository\Interfaces\RepositoryInterface;

interface StatusRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{

}
