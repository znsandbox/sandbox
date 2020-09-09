<?php

namespace yii2bundle\error\module\actions;

use yii2bundle\error\domain\helpers\MessageHelper;

class ErrorAction extends \yii\web\ErrorAction
{
	
	protected function getViewRenderParams()
	{
		return MessageHelper::get($this->exception);
	}
	
}
