<?php

namespace yii2rails\app\domain\filters\env;

use yii\helpers\ArrayHelper;
use yii2rails\app\domain\enums\YiiEnvEnum;
use yii2rails\extension\scenario\base\BaseScenario;

class LoadConfig extends BaseScenario {

	const FILE_ENV = 'env';
	const FILE_ENV_LOCAL = 'env-local';
    const FILE_ENV_TEST = 'env-test';
	const FILE_ENV_SYSTEM_LOCAL = 'env-system-local';
	
	public $paths = [];
	
	public function run() {
		$mainConfig = $this->loadByFileName(self::FILE_ENV);
        $localConfig = $this->loadByFileName(self::FILE_ENV_LOCAL);
		if(defined('YII_ENV') && YII_ENV == 'test') {
            $testConfig = $this->loadByFileName(self::FILE_ENV_TEST);
            $localConfig = ArrayHelper::merge($localConfig, $testConfig);
        }
		$systemLocalConfig = $this->loadByFileName(self::FILE_ENV_SYSTEM_LOCAL);
		$config = ArrayHelper::merge($mainConfig, $localConfig);
		$config = ArrayHelper::merge($config, $systemLocalConfig);
		$this->setData($config);
	}
	
	private function loadByFileName($fileName) {
		foreach($this->paths as $path) {
			$config = $this->load($path, $fileName);
			if(!empty($config)) {
				return $config;
			}
		}
		return [];
	}
	
	private function load($path, $fileName) {
		$config = @include(ROOT_DIR . DS . $path . DS . $fileName . '.php');
		return !empty($config) ? $config : [];
	}
	
}
