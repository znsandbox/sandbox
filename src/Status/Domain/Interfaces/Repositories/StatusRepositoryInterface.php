<?php

namespace ZnSandbox\Sandbox\Status\Domain\Interfaces\Repositories;

use ZnCore\Base\Libs\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Libs\Domain\Interfaces\ReadAllInterface;
use ZnCore\Base\Libs\Repository\Interfaces\FindOneInterface;
use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;

interface StatusRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{

}
