<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Interfaces;

interface CheckAccessInterface
{

    public function checkAccess(?int $userId, string $permissionName, array $params = []);
}
