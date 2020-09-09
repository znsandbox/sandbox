<?php

namespace yii2bundle\lang\domain;

use yii2rails\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @package yii2bundle\lang\domain
 * @property-read \yii2bundle\lang\domain\interfaces\services\LanguageInterface $language
 * @property-read \yii2bundle\lang\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		if(APP == API) {
			$storeDriver = Driver::HEADER;
		} elseif(APP == CONSOLE) {
			$storeDriver = Driver::MOCK;
		} else {
			$storeDriver = Driver::COOKIE;
		}
		return [
			'repositories' => [
				'language' => Driver::ACTIVE_RECORD,
				'store' => $storeDriver,
			],
			'services' => [
				'language',
			],
		];
	}
	
}
