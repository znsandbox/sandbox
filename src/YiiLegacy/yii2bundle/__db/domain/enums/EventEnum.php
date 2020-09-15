<?php

namespace yii2bundle\db\domain\enums;

use yii2rails\extension\enum\base\BaseEnum;

class EventEnum extends BaseEnum {
	
	const BEFORE_DROP_TABLE = 'BEFORE_DROP_TABLE';
	const AFTER_DROP_TABLE = 'AFTER_DROP_TABLE';
	
	const BEFORE_CREATE_TABLE = 'BEFORE_CREATE_TABLE';
	const AFTER_CREATE_TABLE = 'AFTER_CREATE_TABLE';
	
}
