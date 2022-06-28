<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories;

use ZnSandbox\Sandbox\Wsdl\Domain\Entities\ServiceEntity;

interface ServiceRepositoryInterface
{

    public function oneByName(string $appName): ServiceEntity;
}

