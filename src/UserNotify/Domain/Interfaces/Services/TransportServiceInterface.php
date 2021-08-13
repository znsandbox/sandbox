<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;

interface TransportServiceInterface extends CrudServiceInterface
{

    public function send(NotifyEntity $notifyEntity);
}

