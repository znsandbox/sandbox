<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Interfaces;

interface InheritanceMapInterface
{

    public function roleEnums();

    public function permissionEnums();

    public function map();
}
