<?php

namespace yii2bundle\account\domain\v3\forms;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;

class RegistrationForm extends RestorePasswordForm {
	
	public $login;
	public $activation_code;
	public $password;
	public $email;
	
	const SCENARIO_REQUEST_WITH_EMAIL = 'request_with_email';
	const SCENARIO_REQUEST = 'request';
	const SCENARIO_CHECK = 'check';
	const SCENARIO_CONFIRM = 'confirm';
	
	public function rules() {
		return [
			[['login', 'password', 'activation_code', 'email'], 'trim'],
			[['login', 'password', 'activation_code', 'email'], 'required'],
			//['login', LoginValidator::class],
			['email', 'email'],
			[['activation_code'], 'integer'],
			[['activation_code'], 'string', 'length' => 6],
			[['password'], 'string', 'min' => 8],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_REQUEST_WITH_EMAIL => ['login', 'email'],
			self::SCENARIO_REQUEST => ['login'],
			self::SCENARIO_CHECK => ['login', 'activation_code'],
			self::SCENARIO_CONFIRM => ['login', 'activation_code', 'password'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' 		=> I18Next::t('account', 'main.login'),
			'email' 		=> I18Next::t('account', 'main.email'),
			'activation_code' 		=> I18Next::t('account', 'main.activation_code'),
		];
	}
	
}
