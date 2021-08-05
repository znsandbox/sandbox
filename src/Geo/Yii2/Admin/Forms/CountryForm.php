<?php

namespace ZnSandbox\Sandbox\Geo\Yii2\Admin\Forms;

use ZnYii\Base\Forms\BaseForm;

class CountryForm extends BaseForm
{

    public $name = null;
    public $nameI18n = null;

    public function i18NextConfig(): array
    {
        return [
            'bundle' => 'geo',
            'file' => 'country',
        ];
    }

}