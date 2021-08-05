<?php

namespace ZnSandbox\Sandbox\Geo\Yii2\Admin\Forms;

use ZnYii\Base\Forms\BaseForm;

class LocalityForm extends BaseForm
{

    public $name = null;
    public $nameI18n = null;
    public $region_id = null;

    public function i18NextConfig(): array
    {
        return [
            'bundle' => 'geo',
            'file' => 'locality',
        ];
    }

}