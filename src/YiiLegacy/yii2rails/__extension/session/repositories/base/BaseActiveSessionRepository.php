<?php

namespace yii2rails\extension\session\repositories\base;

use yii2rails\domain\interfaces\repositories\CrudInterface;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayModifyTrait;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayReadTrait;

abstract class BaseActiveSessionRepository extends BaseSessionRepository implements CrudInterface {
	
	use ArrayReadTrait;
	use ArrayModifyTrait;
	
}