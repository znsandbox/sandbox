<?php

namespace yii2bundle\db\domain\helpers;

use yii2rails\extension\common\traits\classAttribute\MagicSetTrait;
use yii2rails\extension\psr\container\BaseContainer;

class ConnectionContainer extends BaseContainer
{

    use MagicSetTrait;

    public function setConnections($profiles) {
        $this->setDefinitions($profiles);
    }

    protected function createComponent($component) : object {
        $instance = ConnectionFactoryHelper::createConnectionFromConfig($component);
        return $instance;
    }

}
