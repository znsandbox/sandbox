<?php

namespace yii2bundle\navigation\domain\interfaces\services;

use yii2rails\domain\interfaces\services\CrudInterface;

interface BreadcrumbsInterface extends CrudInterface {
	
	public function create($title, $url = null, $options = null);
	
}