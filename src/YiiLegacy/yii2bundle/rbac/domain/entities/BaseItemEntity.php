<?php

namespace yii2bundle\rbac\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class BaseItemEntity
 * 
 * @package yii2bundle\rbac\domain\entities
 * 
 * @property $name
 * @property $description
 * @property $rule_name
 * @property $data
 * @property $children
 */
class BaseItemEntity extends BaseEntity {

	protected $name;
	protected $description;
	protected $rule_name;
	protected $data;
	protected $children;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'trim'],
        ];
    }

}
