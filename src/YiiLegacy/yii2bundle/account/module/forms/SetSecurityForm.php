<?php

namespace yii2bundle\account\module\forms;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;
use yii2rails\domain\base\Model;

class SetSecurityForm extends Model
{
	
	public $email;
	public $email_repeat;
	public $password;
	public $password_repeat;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email', 'email_repeat', 'password', 'password_repeat'], 'trim'],
			[['email',  'password', 'password_repeat'], 'required'],
			['email', 'email'],
			['password', 'string', 'min' => 6],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password' 		=> I18Next::t('account', 'main.password'),
			'password_repeat' 		=> I18Next::t('account', 'main.password_repeat'),
			'email' 		=> I18Next::t('account', 'main.email'),
		];
	}
	
}
