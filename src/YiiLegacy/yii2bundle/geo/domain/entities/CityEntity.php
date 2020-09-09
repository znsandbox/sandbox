<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;

class CityEntity extends BaseEntity {
	
	protected $id;
	protected $country_id;
	protected $region_id;
	protected $name;
	protected $country;
	protected $region;
	
	public function rules() {
		return [
			[['country_id', 'name'], 'required'],
			[['name'], 'trim'],
			['name', 'string', 'min' => 2],
			[['id', 'country_id', 'region_id'], 'integer'],
		];
	}
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'country_id' => 'integer',
			'region_id' => 'integer',
			'country' => [
				'type' => CountryEntity::class,
			],
			'region' => [
				'type' => RegionEntity::class,
			],
		];
	}
}