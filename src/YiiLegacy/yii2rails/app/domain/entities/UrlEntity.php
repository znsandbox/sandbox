<?php

namespace yii2rails\app\domain\entities;

use yii2rails\domain\BaseEntity;

class UrlEntity extends BaseEntity {

	protected $frontend;
	protected $backend;
	protected $api;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['frontend', 'backend', 'api'], 'required'],
			[['frontend', 'backend', 'api'], 'url'],
		];
	}
}
