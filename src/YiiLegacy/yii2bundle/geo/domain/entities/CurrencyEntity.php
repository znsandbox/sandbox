<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class CurrencyEntity
 *
 * @package yii2bundle\geo\domain\entities
 *
 * @property $id
 * @property $country_id
 * @property $code
 * @property $char
 * @property $name
 * @property $description
 * @property $country
 *
 */
class CurrencyEntity extends BaseEntity {

    protected $id;
    protected $country_id;
    protected $code;
    protected $name;
	protected $char;
    protected $description;
    protected $country;

	public function rules() {
        return [
            [['id', 'name', 'code', 'country_id'], 'required'],
            [['name', 'code'], 'trim'],
            [['name', 'code'], 'string', 'min' => 2],
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
		];
	}
}