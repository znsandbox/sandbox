<?php

namespace yii2rails\extension\common\helpers\time;

use ZnCore\Base\Enums\Http\HttpHeaderEnum;

interface TimeDriverInterface {
	
	public function get();
	public function set(string $timeZone);
	
}
