<?php

namespace yii2rails\extension\common\helpers\time;

use ZnCore\Base\Enums\Http\HttpHeaderEnum;

class TimeMockDriver implements TimeDriverInterface {
	
	public function get() {
		return null;
	}
	
	public function set(string $timeZone) {

	}
	
}
