<?php

namespace yii2rails\domain\enums;

use ZnCore\Domain\Base\BaseEnum;

class RelationEnum extends BaseEnum {
	
	const ONE = 'one';
	const MANY = 'many';
	const MANY_TO_MANY = 'many-to-many';
	
}
