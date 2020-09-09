<?php

namespace yii2rails\app\domain\services;

use yii2rails\domain\services\base\BaseService;

class BaseConfigService extends BaseService {

	public function load() {
		return $this->repository->load();
	}

	public function save($data) {
		$entity = $this->domain->factory->entity->create($this->id, $data);
		return $this->repository->save($entity);
	}

}
