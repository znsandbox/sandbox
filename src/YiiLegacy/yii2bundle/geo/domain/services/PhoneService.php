<?php

namespace yii2bundle\geo\domain\services;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii2rails\domain\data\Query;
use yii2bundle\geo\domain\entities\PhoneEntity;
use yii2bundle\geo\domain\helpers\PhoneHelper;
use yii2bundle\geo\domain\interfaces\services\PhoneInterface;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class PhoneService
 * 
 * @package yii2bundle\geo\domain\services
 * 
 * @property-read \yii2bundle\geo\domain\Domain $domain
 * @property-read \yii2bundle\geo\domain\interfaces\repositories\PhoneInterface $repository
 */
class PhoneService extends BaseActiveService implements PhoneInterface {

	public function oneByPhone(string $phone, Query $query = null) : PhoneEntity {
		/** @var PhoneEntity[] $collection */
		$collection = $this->all($query);
		foreach($collection as $phoneEntity) {
			$isMatch = PhoneHelper::matchPhone($phone, $phoneEntity->rule);
			if($isMatch) {
				return $phoneEntity;
			}
		}
		throw new NotFoundHttpException;
	}
	
	public function parse(string $phone) {
		$phoneEntity = $this->oneByPhone($phone);
		$phoneInfoEntity = PhoneHelper::matchPhone($phone, $phoneEntity->rule);
		return $phoneInfoEntity;
	}
	
	public function format(string $phone) {
		$phoneEntity = $this->oneByPhone($phone);
		return PhoneHelper::formatByMask($phone, $phoneEntity->mask);
	}
	
	public function isValid(string $phone) {
		try {
			$this->oneByPhone($phone);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	public function validate(string $phone) {
		try {
			$this->oneByPhone($phone);
		} catch(NotFoundHttpException $e) {
			throw new InvalidArgumentException(Yii::t('geo/phone', 'bad_format'));
		}
	}
}
