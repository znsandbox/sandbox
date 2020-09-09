<?php

namespace yii2bundle\lang\widgets;

use yii\web\AssetBundle;

class LangSelectorAsset extends AssetBundle
{
    public $sourcePath = '@yii/assets';
    public $js = [
        'yii.activeForm.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
