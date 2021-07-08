<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface PasswordHistoryServiceInterface extends CrudServiceInterface
{

    public function isHas(string $password, int $identityId = null): bool;

    public function add(string $password, int $identityId = null);
}

