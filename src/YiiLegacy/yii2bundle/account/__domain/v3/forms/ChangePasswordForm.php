<?php

namespace yii2bundle\account\domain\v3\forms;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;
use yii2rails\domain\base\Model;

class ChangePasswordForm extends Model
{
	public $new_password;
	public $password;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['password', 'new_password'], 'trim'],
			[['password', 'new_password'], 'required'],
			[['password', 'new_password'], 'string', 'min' => 8],
			['new_password', 'compare', 'compareAttribute' => 'password', 'operator' => '!='],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'password' => I18Next::t('account', 'main.password'),
			'new_password'=> I18Next::t('account', 'security.new_password'),
		];
	}
	
}
