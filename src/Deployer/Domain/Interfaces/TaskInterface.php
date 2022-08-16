<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Interfaces;

interface TaskInterface
{

    public function run();

    public function getTitle(): ?string;
}
