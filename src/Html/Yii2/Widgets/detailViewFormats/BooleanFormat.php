<?php

namespace ZnSandbox\Sandbox\Html\Yii2\Widgets\detailViewFormats;

use ZnCore\Base\Legacy\Yii\Helpers\Html;

class BooleanFormat {
	
	public function run($value) {
		return Html::renderBoolean($value);
	}

}
