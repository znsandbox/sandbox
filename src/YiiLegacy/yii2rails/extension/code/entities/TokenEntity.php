<?php

namespace yii2rails\extension\code\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class TokenEntity
 *
 * @package yii2rails\extension\code\entities
 *
 * @property integer $type
 * @property mixed $value
 * @property integer $line
 */
class TokenEntity extends BaseEntity {
	
	protected $type = null;
	protected $value = null;
	protected $line = null;
	
	public function setType($value) {
		$this->type = intval($value);
	}
	
	public function getTypeName() {
		return token_name($this->type);
	}
	
	public function fields() {
		$fields = parent::fields();
		$fields['type_name'] = 'type_name';
		return $fields;
	}
}