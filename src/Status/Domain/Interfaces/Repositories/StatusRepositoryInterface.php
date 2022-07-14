<?php

namespace ZnSandbox\Sandbox\Status\Domain\Interfaces\Repositories;

use ZnDomain\Domain\Interfaces\GetEntityClassInterface;
use ZnDomain\Domain\Interfaces\ReadAllInterface;
use ZnDomain\Repository\Interfaces\FindOneInterface;
use ZnDomain\Repository\Interfaces\RepositoryInterface;

interface StatusRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{

}
