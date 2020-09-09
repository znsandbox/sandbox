<?php

namespace yii2bundle\account\domain\v3\forms;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;
use yii2rails\domain\base\Model;

class ChangeEmailForm extends Model
{
	public $email;
	public $password;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['password', 'email'], 'trim'],
			[['password', 'email'], 'required'],
			[['password'], 'string', 'min' => 8],
			['email', 'email'],
		];
	}
	
	
	public function attributeLabels()
	{
		return [
			'password' => I18Next::t('account', 'main.password'),
			'email' => I18Next::t('account', 'main.email'),
		];
	}
	
}
