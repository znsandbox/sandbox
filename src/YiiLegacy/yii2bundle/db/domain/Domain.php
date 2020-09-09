<?php

namespace yii2bundle\db\domain;

use yii2rails\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @property-read \yii2bundle\db\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [

			],
			'services' => [

			],
		];
	}
	
}
