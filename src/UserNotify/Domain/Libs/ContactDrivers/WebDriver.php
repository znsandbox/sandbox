<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;

class WebDriver implements ContactDriverInterface
{

    use EntityManagerTrait;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $this->getEntityManager()->persist($notifyEntity);
    }
}