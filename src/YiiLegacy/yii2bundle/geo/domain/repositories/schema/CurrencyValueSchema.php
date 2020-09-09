<?php

namespace yii2bundle\geo\domain\repositories\schema;

use yii2rails\domain\enums\RelationEnum;
use yii2rails\domain\repositories\relations\BaseSchema;

class CurrencyValueSchema extends BaseSchema {
	
	public function relations() {
		return [
			'currency' => [
				'type' => RelationEnum::ONE,
				'field' => 'code',
				'foreign' => [
					'id' => 'geo.currency',
					'field' => 'code',
				],
			],
		];
	}
	
}
