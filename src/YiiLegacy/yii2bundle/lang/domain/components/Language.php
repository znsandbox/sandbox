<?php

namespace yii2bundle\lang\domain\components;

use yii\base\Component;
use yii2rails\domain\helpers\DomainHelper;

class Language extends Component
{

	public function init()
	{
		if(\App::$domain->has('lang')) {
            \App::$domain->lang->language->initCurrent();
        }
	}

}
