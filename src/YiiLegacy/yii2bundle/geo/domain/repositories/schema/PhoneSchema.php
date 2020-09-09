<?php

namespace yii2bundle\geo\domain\repositories\schema;

use yii2rails\domain\enums\RelationEnum;
use yii2rails\domain\repositories\relations\BaseSchema;

/**
 * Class PhoneSchema
 * 
 * @package yii2bundle\geo\domain\repositories\schema
 * 
 */
class PhoneSchema extends BaseSchema {
	
	public function relations() {
		return [
			'country' => [
				'type' => RelationEnum::ONE,
				'field' => 'country_id',
				'foreign' => [
					'id' => 'geo.country',
					'field' => 'id',
				],
			],
		];
	}
	
}
