<?php

namespace yii2rails\extension\package\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\extension\git\domain\entities\GitEntity;
use yii2rails\extension\yii\helpers\FileHelper;

/**
 * Class PackageEntity
 * 
 * @package yii2rails\extension\package\domain\entities
 * 
 * @property $id
 * @property $name
 * @property $group_name
 * @property $alias
 * @property $dir
 * @property GroupEntity $group
 * @property ConfigEntity $config
 * @property GitEntity $git
 */
class PackageEntity extends BaseEntity {

	protected $id;
	protected $name;
	protected $group_name;
	protected $alias;
	protected $dir;
	protected $group;
	protected $config;
	protected $git;
	
	public function getAlias() {
		return '@vendor' . SL . $this->group_name . SL . $this->name;
	}
	
	public function getDir() {
		return FileHelper::getAlias($this->getAlias());
	}
	
	public function getId() {
		return $this->group_name . SL . $this->name;
	}
	
	public function fieldType() {
		return [
			'group' => GroupEntity::class,
			'config' => ConfigEntity::class,
			'git' => GitEntity::class,
		];
	}
	
}
