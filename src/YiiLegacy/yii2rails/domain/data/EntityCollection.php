<?php

namespace yii2rails\domain\data;

use yii\base\InvalidArgumentException;
use yii2rails\extension\arrayTools\helpers\Collection;

class EntityCollection extends Collection {
	
	private $_entityClass;
	
	public function __construct($class, $items = null) {
		$this->setClass($class);
		//$items = $this->validateItems($items);
		parent::__construct($items);
	}
	
	private function setClass($class) {
		if(empty($class)) {
			throw new InvalidArgumentException('Class is empty');
		}
		if(!class_exists($class)) {
			throw new InvalidArgumentException('Class not exists');
		}
		$this->_entityClass = $class;
	}
	
	protected function loadItems($items) {
		$items = $this->validateItems($items);
		return parent::loadItems($items);
	}
	
	private function validateItems($items) {
		if(empty($items)) {
			return [];
		}
		foreach($items as &$item) {
			$item = $this->validateItem($item);
		}
		return $items;
	}
	
	private function validateItem($item) {
		$class = $this->_entityClass;
		if(is_object($item)) {
			if(!$item instanceof $class) {
				throw new InvalidArgumentException('Object not instance of class');
			}
		} elseif(is_array($item)) {
			$item = new $class($item);
		} else {
			throw new InvalidArgumentException('Entity data not array or object!');
		}
		return $item;
	}
	
	public function offsetSet($offset, $value) {
		$value = $this->validateItem($value);
		parent::offsetSet($offset, $value);
	}
	
}
