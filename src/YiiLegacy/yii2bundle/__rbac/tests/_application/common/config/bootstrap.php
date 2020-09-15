<?php

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

$testDir = FileHelper::up(__DIR__, 3);

Yii::setAlias('@tests', $testDir);
