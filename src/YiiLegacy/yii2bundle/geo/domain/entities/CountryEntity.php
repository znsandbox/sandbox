<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class CountryEntity
 *
 * @package yii2bundle\geo\domain\entities
 *
 * @property $id
 * @property $name
 * @property $alpha2
 * @property $alpha3
 * @property $currency
 * @property $phone
 */
class CountryEntity extends BaseEntity {
	
	protected $id;
    protected $name;
	protected $alpha2;
	protected $alpha3;
    protected $currency;
	protected $phone;
    //protected $cities;
    //protected $regions;

	public function rules() {
		return [
			[['id', 'name'], 'required'],
			[['name'], 'trim'],
			[['name'], 'string', 'min' => 2],
			[['id'], 'integer'],
		];
	}
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'currency' => CurrencyEntity::class,
			'phone' => PhoneEntity::class,
		];
	}
}