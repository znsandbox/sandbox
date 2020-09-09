<?php

namespace yii2rails\app\domain\filters\config;

use yii2rails\extension\common\helpers\ClassHelper;
use yii2rails\extension\common\helpers\Helper;

class LoadModuleConfig extends LoadConfig {
	
	public $assignTo = 'modules';
	
	protected function normalizeItem($name, $data) {
		$data = ClassHelper::normalizeComponentConfig($data);
		$data = Helper::isEnabledComponent($data);
		if(empty($data)) {
			return null;
		}
		return $data;
	}
	
}
