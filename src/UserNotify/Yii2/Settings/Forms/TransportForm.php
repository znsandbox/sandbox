<?php

namespace ZnSandbox\Sandbox\UserNotify\Yii2\Settings\Forms;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnYii\Base\Forms\BaseForm;

class TransportForm extends BaseForm
{

    private $map = [];

    public function __get($name)
    {
        return ArrayHelper::getValue($this->map, $name);
    }

    public function __set($name, $value)
    {
        ArrayHelper::setValue($this->map, $name, $value);
    }

    public function setAttributes($values, $safeOnly = true)
    {
        $this->map = $values;
    }

    public function i18NextConfig(): array
    {
        return [
            'bundle' => 'notify',
            'file' => 'transport',
        ];
    }
}
