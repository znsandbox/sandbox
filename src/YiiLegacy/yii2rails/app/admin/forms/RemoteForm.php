<?php

namespace yii2rails\app\admin\forms;

use Yii;
use yii2rails\domain\base\Model;

class RemoteForm extends Model {

	public $driver;
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'driver' => Yii::t('app/remote', 'driver'),
		];
	}
}