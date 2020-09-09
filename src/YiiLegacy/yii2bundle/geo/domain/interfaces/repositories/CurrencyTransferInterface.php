<?php

namespace yii2bundle\geo\domain\interfaces\repositories;

/**
 * Interface CurrencyTransferInterface
 * 
 * @package yii2bundle\geo\domain\interfaces\repositories
 * 
 * @property-read \yii2bundle\geo\domain\interfaces\repositories\PhoneInterface $phone
 */
interface CurrencyTransferInterface {
	
	/**
	 * @return CurrencyValueEntity[]
	 */
	public function all();
	
}
