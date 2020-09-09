<?php

namespace yii2bundle\navigation\domain\services;

use yii2rails\domain\services\base\BaseActiveService;
use yii2bundle\navigation\domain\interfaces\services\BreadcrumbsInterface;

/**
 * Class BreadcrumbsService
 *
 * @package yii2bundle\navigation\domain\services
 * @property \yii2bundle\navigation\domain\interfaces\repositories\BreadcrumbsInterface $repository
 */
class BreadcrumbsService extends BaseActiveService implements BreadcrumbsInterface {

	public function create($title, $url = null, $options = null) {
		$entity = $this->domain->factory->entity->create('breadcrumbs', [
			'label' => $title,
			'url' => $url,
			'options' => $options,
		]);
		$this->repository->insert($entity);
	}
	
}
