<?php

namespace yii2rails\domain\behaviors\query;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii2bundle\db\domain\enums\DbDriverEnum;
use yii2bundle\db\domain\helpers\ConnectionHelper;
use yii2rails\domain\data\Query;

class NullsLastOrderFilter extends BaseQueryFilter {
	
	public $attribute;
	
	public function prepareQuery(Query $query) {
		$driver = ConnectionHelper::getDriverFromDb(Yii::$app->db);
		if($driver != DbDriverEnum::PGSQL) {
			return;
		}
		$orders = $query->getParam('order');
		if(ArrayHelper::getValue($orders, $this->attribute)) {
			$query->removeParam('order');
			foreach($orders as $orderName => $orderValue) {
				if($orderName == $this->attribute) {
					$expression = new Expression('"' . $this->attribute . '" DESC NULLS LAST');
					$query->addOrderBy($expression);
				} else {
					$query->addOrderBy([$orderName => $orderValue]);
				}
			}
		}
	}
}
