<?php

namespace yii2bundle\navigation\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\domain\values\LangValue;

/**
 * @property string $type
 * @property boolean $closable
 * @property integer $delay
 * @property string $content
 * @property string $subject
 */
class AlertEntity extends BaseEntity {

	const DELAY_DEFAULT = 5000;

	protected $type;
	protected $subject;
	protected $content;
	protected $closable = true;
	protected $delay = self::DELAY_DEFAULT;
	
	public function fieldType() {
		return [
			'subject' => LangValue::class,
			'content' => LangValue::class,
		];
	}
	
}
