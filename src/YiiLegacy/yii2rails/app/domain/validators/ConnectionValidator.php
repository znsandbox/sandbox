<?php

namespace yii2rails\app\domain\validators;

use yii\db\ActiveRecord;
use yii\validators\Validator;
use yii2bundle\db\domain\helpers\ConnectionHelper;

class ConnectionValidator extends Validator {

	public function validateAttribute($model, $attribute) {
		/** @var ActiveRecord $model */
		$config = $model->toArray();
		ConnectionHelper::test($config);
	}

}
