<?php

namespace yii2bundle\rbac\domain\interfaces\services;

use yii\base\InvalidConfigException;
use yii\rbac\Item;
use yii\rbac\Rule;
use yii2rails\domain\interfaces\services\CrudInterface;

interface RoleInterface extends CrudInterface {
	
	public function updateAll();
}