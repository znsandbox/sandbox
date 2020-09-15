<?php

namespace yii2rails\domain;

/**
 * Class RestEntity
 *
 * @package yii2bundle\rest\domain\entities
 *
 * @property $id
 */
class BaseEntityWithId extends BaseEntity {
	
	protected $id;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		if(empty($this->id)) {
			$this->id = $value;
		}
	}
	
}