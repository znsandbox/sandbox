<?php

namespace ZnSandbox\Sandbox\Web\Yii2\Traits;

use yii2rails\extension\web\helpers\Behavior;

trait BehaviorTrait
{

    public function behaviors()
    {
        $behaviors = [];
        if ($this->access()) {
            foreach ($this->access() as $accessItem) {
                $behaviors[] = Behavior::access($accessItem[0], $accessItem[1]);
            }
        }
        if ($this->verbs()) {
            $behaviors[] = Behavior::verb($this->verbs());
        }
        if ($this->authentication()) {
            $behaviors[] = Behavior::auth($this->authentication());
        }
        return $behaviors;
    }

    public function access(): array
    {
        return [];
    }

    public function authentication(): array
    {
        return [];
    }

    public function verbs(): array
    {
        return [];
    }

}
