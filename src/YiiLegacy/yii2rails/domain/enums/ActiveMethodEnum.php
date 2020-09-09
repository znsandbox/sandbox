<?php

namespace yii2rails\domain\enums;

use yii2rails\extension\enum\base\BaseEnum;

class ActiveMethodEnum extends BaseEnum {
	
	const READ_COUNT = 'COUNT';
	const READ_ALL = 'READ_ALL';
	const READ_ONE = 'READ_ONE';
	const UPDATE = 'UPDATE';
	const CREATE = 'CREATE';
	const DELETE = 'DELETE';
	
}
