<?php

namespace ZnLib\Web\Yii2\Widgets\detailViewFormats;

use ZnLib\Web\Helpers\Html;

class BooleanFormat {
	
	public function run($value) {
		return Html::renderBoolean($value);
	}

}
