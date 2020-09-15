<?php

namespace yii2bundle\rbac\domain\entities;

use yii2rails\domain\BaseEntity;

class RuleEntity extends BaseEntity {

	protected $name;
	protected $class;

	public function getName() {
		if(!empty($this->name)) {
			return $this->name;
		}
		return basename(get_class($this));
	}

}