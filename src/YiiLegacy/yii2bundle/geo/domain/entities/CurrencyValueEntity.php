<?php

namespace yii2bundle\geo\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\domain\values\TimeValue;

/**
 * Class CurrencyValueEntity
 *
 * @package yii2bundle\geo\domain\entities
 *
 * @property $code
 * @property $value
 * @property $publicated_at
 * @property CurrencyEntity $currency
 */
class CurrencyValueEntity extends BaseEntity {

    protected $code;
	protected $value;
	protected $publicated_at;
	protected $currency;
	
	public function fieldType() {
		return [
			'code' => 'string',
			'value' => 'float',
			'publicated_at' => TimeValue::class,
			'currency' => CurrencyEntity::class,
		];
	}
	
}