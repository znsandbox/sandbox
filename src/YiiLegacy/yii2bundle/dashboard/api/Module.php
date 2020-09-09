<?php

namespace yii2bundle\dashboard\api;

use yii\base\Module as YiiModule;
use yii2rails\domain\helpers\DomainHelper;

class Module extends YiiModule
{
	
	public function init() {
		DomainHelper::forgeDomains([
			'dashboard' => 'yii2bundle\dashboard\domain\Domain',
		]);
		parent::init();
	}
	
}
