<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface SystemServiceInterface extends CrudServiceInterface
{

    public function view(string $name): array;

    public function update(string $name, array $data): void;
}
