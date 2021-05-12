<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\SettingEntity;

interface SettingServiceInterface
{

    /**
     * @param int $userId
     * @param int $typeId
     * @return Collection | SettingEntity[]
     */
    public function allByUserAndType(int $userId, int $typeId): Collection;

    /**
     * @param int $userId
     * @return Collection | SettingEntity[]
     */
//    public function allByUserId(int $userId): Collection;
}

