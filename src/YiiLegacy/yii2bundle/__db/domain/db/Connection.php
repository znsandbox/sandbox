<?php

namespace yii2bundle\db\domain\db;

use yii\helpers\ArrayHelper;
use yii2bundle\db\domain\helpers\DbHelper;

class Connection extends \yii\db\Connection
{
	
	public $charset = 'utf8';
	public $enableSchemaCache = YII_ENV_PROD;
	
	public function __construct(array $config = []) {
		$name = YII_ENV_TEST ? 'test' : 'main';
		$connectionFromEnv = DbHelper::getConfigFromEnv($name);
		$config = ArrayHelper::merge($connectionFromEnv, $config);
        if(isset($config['defaultSchema'])) {
            unset($config['defaultSchema']);
        }
		parent::__construct($config);
	}
	
}
