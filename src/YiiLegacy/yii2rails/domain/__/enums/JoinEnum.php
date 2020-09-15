<?php

namespace yii2rails\domain\enums;

use ZnCore\Domain\Base\BaseEnum;

class JoinEnum extends BaseEnum {

    const JOIN = 'JOIN';
    const INNER = 'INNER JOIN';
	const LEFT = 'LEFT JOIN';
	const RIGHT = 'RIGHT JOIN';
	const FULL = 'FULL JOIN';
	const OUTER = 'OUTER JOIN';
	const CROSS = 'CROSS JOIN';

}
