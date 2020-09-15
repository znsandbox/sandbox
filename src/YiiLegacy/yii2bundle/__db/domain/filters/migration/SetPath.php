<?php

namespace yii2bundle\db\domain\filters\migration;

//use common\enums\app\ApiVersionEnum;
use Yii;
use yii2rails\app\domain\enums\AppEnum;
use yii2rails\extension\scenario\base\BaseScenario;
use yii2rails\extension\common\helpers\ModuleHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class SetPath extends BaseScenario {

	public $path = [];
	public $scan = [];
	
	private $aliases;
	
	public function isEnabled() {
		return APP == CONSOLE;
	}
	
	public function run() {
		$config = $this->getData();
		$config['params']['dee.migration.scan'] = ArrayHelper::merge(
			ArrayHelper::getValue($config, 'params.dee.migration.scan', []),
			$this->scan
		);
		$config['params']['dee.migration.path'] = ArrayHelper::merge(
			ArrayHelper::getValue($config, 'params.dee.migration.path', []),
			$this->getAliases($config),
			$this->path
		);
		$this->setData($config);
	}
	
	private function getAliases($config) {
		$this->aliases = [];
		$apps = [];
        if(class_exists(AppEnum::class)) {
            $apps = AppEnum::values();
        }
		/*if(class_exists(ApiVersionEnum::class)) {
            $apps = ArrayHelper::merge($apps, ApiVersionEnum::getApiSubApps());
        }*/
		foreach($apps as $app) {
			$this->getAppMigrations($app);
		}
		if(!empty($config['params']['dee.migration.scan'])) {
			$scanAliases = $config['params']['dee.migration.scan'];
			if(!empty($scanAliases)) {
				foreach($scanAliases as $target) {
					$this->scanMigrations($target);
				}
			}
		}
		$aliases = array_unique($this->aliases);
		return $aliases;
	}
	
	private function addMigrationsDir($dir) {
		if(is_dir($dir)) {
			$this->aliases[] = '@' . $dir;
		}
	}
	
	private function scanMigrations($path) {
		$dir = Yii::getAlias($path);
		if(!FileHelper::has($dir)) {
		    return [];
        }
		$pathList = FileHelper::findFiles($dir);
		foreach($pathList as $pathItem) {
			if(strpos($pathItem, 'migrations') !== false) {
				$alias = $this->extractAlias($pathItem);
				$this->addMigrationsDir($alias);
			}
		}
	}
	
	private function extractAlias($pathItem) {
		$dirName = dirname($pathItem);
		$dirName = str_replace(ROOT_DIR . DS, '', $dirName);
		$dirName = str_replace('\\', '/', $dirName);
		return $dirName;
	}
	
	private function getAppMigrations($app) {
		$this->addMigrationsDir($app . '/migrations');
		$modules = ModuleHelper::allNamesByApp($app);
		foreach($modules as $module) {
			$dir = $app . '/modules/' . $module . '/migrations';
			$this->addMigrationsDir($dir);
		}
	}
}
