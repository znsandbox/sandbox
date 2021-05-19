<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface AssignmentServiceInterface extends CrudServiceInterface
{

    public function getRolesByIdentityId(int $identityId): array;
}

