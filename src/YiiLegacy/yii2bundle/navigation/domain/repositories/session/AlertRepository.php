<?php

namespace yii2bundle\navigation\domain\repositories\session;

use yii2rails\extension\session\repositories\base\BaseActiveSessionRepository;
use yii2bundle\navigation\domain\interfaces\repositories\AlertInterface;

class AlertRepository extends BaseActiveSessionRepository implements AlertInterface {
	
	public $isFlash = true;
	
}