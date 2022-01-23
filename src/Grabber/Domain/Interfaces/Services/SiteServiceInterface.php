<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;

interface SiteServiceInterface extends CrudServiceInterface
{

    public function forgeEntityByUrl(string $url): SiteEntity;
}

