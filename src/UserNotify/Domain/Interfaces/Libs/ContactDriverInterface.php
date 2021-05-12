<?php


namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;

interface ContactDriverInterface
{

    public function send(NotifyEntity $notifyEntity);
}