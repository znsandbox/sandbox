<?php

namespace yii2bundle\geo\domain\services;

use yii2bundle\geo\domain\entities\CurrencyValueEntity;
use yii2rails\domain\data\Query;
use yii2rails\domain\services\base\BaseActiveService;
use yii2rails\domain\values\TimeValue;

class CurrencyValueService extends BaseActiveService {
	
	public function all(Query $query = null) {
		$query = Query::forge($query);
		$timeValue = $this->forgeTodayTimeValue();
		$query->andWhere(['publicated_at' => $timeValue->getInFormat(TimeValue::FORMAT_WEB)]);
		/** @var CurrencyValueEntity[] $collection */
		$collection = parent::all($query);
        if(empty($collection)) {
            $this->makeCash($timeValue);
            $collection = parent::all($query);
        }
		return $collection;
	}

	private function forgeTodayTimeValue() {
        $dateTime = new \DateTime;
        $dateTime->setTime(0,0,0,0);
        $timeValue = new TimeValue($dateTime);
        return $timeValue;
    }

    private function makeCash($timeValue)
    {
        $collection = $this->domain->repositories->currencyTransfer->all();
        foreach($collection as $entity) {
            $entity->publicated_at = $timeValue;
            $this->repository->insert($entity);
        }
    }
}
