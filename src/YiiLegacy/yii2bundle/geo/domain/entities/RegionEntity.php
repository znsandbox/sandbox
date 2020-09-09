<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;

class RegionEntity extends BaseEntity {
	
	protected $id;
    protected $country_id;
    protected $name;
    protected $country;
    protected $cities;

	public function rules() {
		return [
			[['name'], 'trim'],
			[['name', 'country_id'], 'required'],
			[['id', 'country_id'], 'integer'],
		];
	}
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'country_id' => 'integer',
			'country' => [
				'type' => CountryEntity::class,
			],
			'cities' => [
				'type' => CityEntity::class,
				'isCollection' => true,
			],
		];
	}
}