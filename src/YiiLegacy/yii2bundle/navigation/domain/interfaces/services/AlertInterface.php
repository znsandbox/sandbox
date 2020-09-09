<?php

namespace yii2bundle\navigation\domain\interfaces\services;

use yii2rails\domain\interfaces\services\CrudInterface;
use yii2bundle\navigation\domain\entities\AlertEntity;
use yii2bundle\navigation\domain\widgets\Alert;

interface AlertInterface extends CrudInterface {
	
	public function create($content, $type = Alert::TYPE_SUCCESS, $delay = AlertEntity::DELAY_DEFAULT);
	
}