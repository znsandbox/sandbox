<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class PhoneEntity
 * 
 * @package yii2bundle\geo\domain\entities
 * 
 * @property $id
 * @property $country_id
 * @property $mask
 * @property $rule
 * @property CountryEntity $country
 */
class PhoneEntity extends BaseEntity {

	protected $id;
	protected $country_id;
	protected $mask;
	protected $rule;
	protected $country;
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'country_id' => 'integer',
			'country' => CountryEntity::class,
		];
	}
}
