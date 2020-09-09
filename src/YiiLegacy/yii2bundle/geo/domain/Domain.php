<?php

namespace yii2bundle\geo\domain;

use yii2rails\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @package yii2bundle\geo\domain
 * @property \yii2bundle\geo\domain\services\RegionService $region
 * @property \yii2bundle\geo\domain\services\CityService $city
 * @property \yii2bundle\geo\domain\services\CountryService $country
 * @property \yii2bundle\geo\domain\services\CurrencyService $currency
 * @property \yii2bundle\geo\domain\services\CurrencyValueService $currencyValue
 * @property-read \yii2bundle\geo\domain\interfaces\services\PhoneInterface $phone
 * @property-read \yii2bundle\geo\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'region' => Driver::slave(),
				'city' => Driver::slave(),
				'country' => Driver::slave(),
				'currency' => Driver::slave(),
				'currencyValue' => Driver::slave(),
				'currencyTransfer' => 'nationalbankKz',
				'phone' => Driver::FILEDB,
			],
			'services' => [
				'region',
				'city',
				'country',
				'currency',
				'currencyValue',
				'phone',
			],
		];
	}
	
}