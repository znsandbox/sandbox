<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\Repository\RepositoryInterface;

interface SwitchRepositoryInterface extends RepositoryInterface
{

    public function getId(): int;

    public function setId(int $id): void;

    public function reset(): void;
}
