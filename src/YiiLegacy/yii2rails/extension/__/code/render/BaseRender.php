<?php

namespace yii2rails\extension\code\render;

use ZnCore\Base\Libs\Scenario\Base\BaseScenario;
use yii2rails\domain\BaseEntity;

abstract class BaseRender extends BaseScenario
{
	/**
	 * @var BaseEntity
	 */
	public $entity;
	
	protected function renderItem($entity) {
	
	}
	
	protected function render($renderClass) {
		/** @var BaseRender $render */
		$render = new $renderClass();
		$render->entity = $this->entity;
		return $render->run();
	}
	
	protected function renderItems($items) {
		$code = '';
		foreach($items as $entity) {
			$code .= $this->renderItem($entity);
		}
		return $code;
	}
}
