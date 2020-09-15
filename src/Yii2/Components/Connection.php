<?php

namespace ZnSandbox\Sandbox\Yii2\Components;

use ZnCore\Db\Db\Helpers\DbHelper;

// todo: переместить в zncore\db
class Connection extends \yii\db\Connection
{

    public $charset = 'utf8';
    public $enableSchemaCache = YII_ENV_PROD;

    public function __construct(array $config = []) {
        if(empty($config)) {
            $connections = DbHelper::getConfigFromEnv();
            $config = $connections['default'];
            $config = DbHelper::buildConfigForPdo($config);
        }
        parent::__construct($config);
    }

}