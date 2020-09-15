<?php

use yii\helpers\ArrayHelper;
use yii2tool\test\helpers\TestHelper;

$config = [
	'lang' => [
        'class' => 'yii2bundle\lang\domain\Domain',
        'repositories' => [
            'language' => \yii2rails\domain\enums\Driver::FILEDB,
        ],
    ],
];

$baseConfig = TestHelper::loadConfig('common/config/domains.php');
return ArrayHelper::merge($baseConfig, $config);
