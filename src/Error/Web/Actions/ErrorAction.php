<?php

namespace ZnSandbox\Sandbox\Error\Web\Actions;

use ZnSandbox\Sandbox\Error\Domain\Helpers\MessageHelper;

class ErrorAction extends \yii\web\ErrorAction
{
	
	protected function getViewRenderParams()
	{
		return MessageHelper::get($this->exception);
	}
	
}
