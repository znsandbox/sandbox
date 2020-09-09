<?php

namespace yii2rails\extension\arrayTools\helpers;

use Yii;
use yii2rails\extension\arrayTools\base\BaseCollection;
use yii2rails\extension\yii\helpers\ArrayHelper;

class Collection extends BaseCollection {
	
	public static function forge($items = null) {
		$collection = Yii::createObject(static::class);
		$collection->load($items);
		return $collection;
	}
	
	public static function createInstance($items) {
		return new static($items);
	}
	
	public function keys() {
		return array_keys($this->all());
	}
	
	public function values() {
		return array_values($this->all());
	}
	
	public function first() {
		if($this->count() == 0) {
			return null;
		}
		return $this->offsetGet(0);
	}
	
	public function last() {
		if($this->count() == 0) {
			return null;
		}
		$lastIndex = $this->count() - 1;
		return $this->offsetGet($lastIndex);
	}
	
	public function fetch() {
		if(!$this->valid()) {
			return false;
		}
		$item = $this->current();
		$this->next();
		return $item;
	}
	
	public function load($items) {
		$this->loadItems($items);
	}

}
