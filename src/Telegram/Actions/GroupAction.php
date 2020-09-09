<?php

namespace ZnSandbox\Telegram\Actions;

use App\Core\Entities\RequestEntity;
use ZnSandbox\Telegram\Base\BaseAction;

class GroupAction extends BaseAction
{

    /** @var array | BaseAction[] */
    private $actions;

    public function __construct(array $actions)
    {
        parent::__construct();
        $this->actions = $actions;
    }

    public function run(RequestEntity $requestEntity)
    {
        foreach ($this->actions as $actionInstance) {
            $actionInstance->run($requestEntity);
        }
    }

}
