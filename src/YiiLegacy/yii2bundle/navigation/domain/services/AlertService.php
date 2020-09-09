<?php

namespace yii2bundle\navigation\domain\services;

use yii2rails\domain\services\base\BaseActiveService;
use yii2bundle\navigation\domain\interfaces\services\AlertInterface;
use yii2bundle\navigation\domain\entities\AlertEntity;
use yii2bundle\navigation\domain\widgets\Alert;

/**
 * Class AlertService
 *
 * @package yii2bundle\navigation\domain\services
 * @property \yii2bundle\navigation\domain\interfaces\repositories\AlertInterface $repository
 */
class AlertService extends BaseActiveService implements AlertInterface {
	
	public function create($content, $type = Alert::TYPE_SUCCESS, $delay = AlertEntity::DELAY_DEFAULT) {
		$entity = $this->repository->forgeEntity([
			'type' => $type,
			'content' => $content,
			'delay' => $delay,
		]);
		$this->repository->insert($entity);
	}
	
}
