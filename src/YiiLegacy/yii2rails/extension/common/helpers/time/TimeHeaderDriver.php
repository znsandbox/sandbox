<?php

namespace yii2rails\extension\common\helpers\time;

use ZnCore\Base\Enums\Http\HttpHeaderEnum;

class TimeHeaderDriver implements TimeDriverInterface {
	
	public function get() {
		return \Yii::$app->request->headers->get(HttpHeaderEnum::TIME_ZONE);
	}
	
	public function set(string $timeZone) {
	
	}
	
}
