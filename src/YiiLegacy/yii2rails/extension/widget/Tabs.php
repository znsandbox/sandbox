<?php

namespace yii2rails\extension\widget;

use yii\base\Widget;
use yii\bootstrap\Nav;
use yii2rails\extension\menu\helpers\MenuHelper;

/**
 * Class Tabs
 *
 * @package yii2rails\extension\widget
 *
 * @deprecated
 */
class Tabs extends Widget
{

	public $id = 'tabs_navigation';
    public $items = [];
	
	public function run() {
		echo Nav::widget([
			'options' => [
				'id' => $this->id,
                'class' => 'nav nav-tabs',
            ],
			'items' => $this->items,
		]);
	}

}
