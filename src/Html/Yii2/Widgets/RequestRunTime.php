<?php

namespace ZnSandbox\Sandbox\Html\Yii2\Widgets;

use yii\base\Widget;
use ZnSandbox\Sandbox\Develop\Helpers\Debug;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\Html;

class RequestRunTime extends Widget {
	
	public $precision = 2;
	
	public function run() {
		$runtime = Debug::getRuntime(TimeEnum::SECOND_PER_SECOND, $this->precision);
		$labelSecond = $runtime . ' s';
		$labelMillisecond = Debug::getRuntime(TimeEnum::SECOND_PER_MILLISECOND, 0) . ' ms';
		$hint = 'runtime: ' . $labelSecond . ' (' . $labelMillisecond . ')';
		echo Html::tag('span', $labelSecond, [
			'title' => $hint,
		]);
	}
	
}