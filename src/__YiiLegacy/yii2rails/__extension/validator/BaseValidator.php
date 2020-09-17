<?php

namespace yii2rails\extension\validator;

use yii\validators\Validator;
use ZnBundle\Language\Yii2\Helpers\LangHelper;

abstract class BaseValidator extends Validator {
	
	public $allowCountriesId;
	protected $messageLang;
	
	public function init()
	{
		parent::init();
		if ($this->message === null) {
			$this->message = LangHelper::extract($this->messageLang);
		}
	}
	
	protected function prepareMessage($isValid, $message = null) {
		$message = $message ? $message : $this->message;
		return $isValid ? null : [$message, []];
	}
	
}
