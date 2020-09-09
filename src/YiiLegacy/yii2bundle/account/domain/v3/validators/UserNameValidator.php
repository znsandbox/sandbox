<?php

namespace yii2bundle\account\domain\v3\validators;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;
use yii\validators\StringValidator;
use yii2rails\extension\validator\BaseValidator;

class UserNameValidator extends BaseValidator {

	public function validateAttribute($model, $attribute) {
        $model->$attribute = trim($model->$attribute);

        $punctuationCharExists = preg_match('/[!"#$%&()*+,.\/:;<=>?@[\]^_`{|}~]/', $model->$attribute);
        $numericExists = preg_match('/[\d]/', $model->$attribute);
		if($punctuationCharExists | $numericExists) {
			$this->addError($model, $attribute, I18Next::t('account', 'main.bad_name'));
		}
	}
}
