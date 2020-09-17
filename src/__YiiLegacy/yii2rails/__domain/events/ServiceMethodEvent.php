<?php

namespace yii2rails\domain\events;

use yii\base\ActionEvent;
use yii\base\Event;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\Query;
use ZnCore\Base\Libs\ArrayTools\Helpers\Collection;

class ServiceMethodEvent extends ActionEvent {

	public $params = [];

}
