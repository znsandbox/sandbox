<?php

namespace yii2bundle\geo\domain\interfaces\services;

use yii2rails\domain\data\Query;
use yii2rails\domain\interfaces\services\CrudInterface;
use yii2bundle\geo\domain\entities\PhoneEntity;
use yii2bundle\geo\domain\entities\PhoneInfoEntity;

/**
 * Interface PhoneInterface
 * 
 * @package yii2bundle\geo\domain\interfaces\services
 * 
 * @property-read \yii2bundle\geo\domain\Domain $domain
 * @property-read \yii2bundle\geo\domain\interfaces\repositories\PhoneInterface $repository
 */
interface PhoneInterface extends CrudInterface {
	
	public function oneByPhone(string $phone, Query $query = null) : PhoneEntity;
	
	/**
	 * @param string $phone
	 *
	 * @return PhoneInfoEntity
	 */
	public function parse(string $phone);
	public function format(string $phone);
	public function isValid(string $phone);
	public function validate(string $phone);
	
}
