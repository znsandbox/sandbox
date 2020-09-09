<?php

namespace yii2rails\app;

use yii2rails\app\domain\helpers\Config;
use yii2rails\app\domain\helpers\Env;

Env::init('vendor/yii2tool/yii2-test/src/base/_application');
$definition = Env::get('config');
return Config::loadData($definition);