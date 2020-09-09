<?php

namespace yii2rails\domain\helpers;

use ZnCore\Base\Libs\I18Next\Services\TranslationService;
use Yii;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;

class ErrorCollection {
	
	protected $error = [];
	
	public function __construct($field = null, $file = null, $name = null, $values = []) {
		if(func_num_args() >= 3) {
			$this->add($field, $file, $name, $values);
		}
	}
	
	public function show() {
		throw new UnprocessableEntityHttpException($this->error);
	}

    public function addError($field, $bundleName,$name  = null, $values = []) {
        $i18n = new TranslationService;
        if(!empty($name)) {
            $message = $i18n->t($bundleName, $name, $values);
        } else {
            $message = $bundleName;
        }
        $this->error[] = [
            'field' => $field,
            'message' => $message,
        ];
        return $this;
    }

    /** @deprecated use self::addError */
	public function add($field, $fileOrMessage, $name = null, $values = []) {
		if(!empty($name)) {
			$message = Yii::t($fileOrMessage, $name, $values);
		} else {
			$message = $fileOrMessage;
		}
		$this->error[] = [
			'field' => $field,
			'message' => $message,
		];
		return $this;
	}
	
	public function has() {
		return !empty($this->error);
	}
	
	public function count() {
		return count($this->error);
	}
	
	public function all() {
		return $this->error;
	}
	
	public function forge($errors) {
		$this->error = $errors;
		return $this;
	}
	
	public function clear() {
		$this->error = [];
		return $this;
	}
	
}