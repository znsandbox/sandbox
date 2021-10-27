<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Repositories\Yii2;

use yii\web\Session;
use ZnSandbox\Sandbox\Organization\Domain\Entities\SwitchEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\SwitchRepositoryInterface;

class SwitchRepository implements SwitchRepositoryInterface
{

    const SESSION_PARAM_NAME = 'currentOrganizationId';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getId(): ?int
    {
        return $this->session->get(self::SESSION_PARAM_NAME);
    }

    public function setId(int $id): void
    {
        $this->session->set(self::SESSION_PARAM_NAME, $id);
    }

    public function reset(): void
    {
        $this->session->remove(self::SESSION_PARAM_NAME);
    }
}
