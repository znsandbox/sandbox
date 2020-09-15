<?php

namespace yii2bundle\lang\module\helpers;

use yii2rails\extension\menu\interfaces\MenuInterface;
use yii2bundle\lang\domain\enums\LangPermissionEnum;

class Menu implements MenuInterface {
	
	public function toArray() {
		return [
			'label' => ['lang/main', 'title'],
			'url' => 'lang/manage',
			'module' => 'lang',
			//'icon' => 'language',
			'access' => LangPermissionEnum::MANAGE,
		];
	}

}
