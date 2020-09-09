<?php

namespace yii2rails\app\domain\filters\config;

use yii2rails\extension\scenario\base\BaseScenario;

class SetControllerNamespace extends BaseScenario {
	
	public function run() {
		$config = $this->getData();
		if(empty($config['controllerNamespace'])) {
			$config['controllerNamespace'] = APP . '\controllers';
		}
		$this->setData($config);
	}
	
}
