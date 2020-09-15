<?php

namespace yii2bundle\lang\domain\interfaces\repositories;

interface StoreInterface {
	
	public function set($value);
	public function get($def = null);
	public function has();
	public function remove();
	
}
