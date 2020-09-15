<?php

namespace ZnCore\Base\Libs\ArrayTools\Repositories\Base;

use yii2rails\domain\interfaces\repositories\CrudInterface;
use yii2rails\domain\repositories\BaseRepository;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayModifyTrait;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayReadTrait;

abstract class BaseActiveArrayRepository extends BaseRepository implements CrudInterface {
	
	use ArrayReadTrait;
	use ArrayModifyTrait;
	
	private $collection = [];
	
	protected function setCollection(Array $collection) {
		$this->collection = $collection;
	}
	
	protected function getCollection() {
		return $this->collection;
	}
}
