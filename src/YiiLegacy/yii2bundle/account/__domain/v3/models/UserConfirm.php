<?php

namespace yii2bundle\account\domain\v3\models;

use yii\db\ActiveRecord;
use yii2bundle\db\domain\behaviors\json\JsonBehavior;
use yii2bundle\db\domain\helpers\TableHelper;

/**
 * Class UserConfirm
 *
 * @package yii2bundle\account\domain\v3\models
 *
 * @property $login
 * @property $action
 * @property $code
 * @property $data
 * @property $expire
 * @property $created_at
 */
class UserConfirm extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
        return TableHelper::getGlobalName('user_confirm');
	}
	
	public static function primaryKey()
	{
		return ['login', 'action'];
	}
	
	public function behaviors()
	{
		return [
			'rulesJson' => [
				'class' => JsonBehavior::class,
				'attributes' => ['data'],
			],
		];
	}
	
}
