<?php

namespace yii2bundle\rbac\domain\repositories\file;

use yii2rails\domain\repositories\BaseRepository;
use yii2bundle\rbac\domain\helpers\GenerateHelper;

class ConstRepository extends BaseRepository {

	public $dirAlias = '@common/enums/rbac';
	

	public function generatePermissions($collection)
	{
		$constList = GenerateHelper::getConstListFromCollection($collection, GenerateHelper::PREFIX_PERMISSION);
		$className = $this->dirAlias . SL . GenerateHelper::TYPE_PERMISSION;
		GenerateHelper::generateEnum($className, $constList);
		return $constList;
	}

	public function generateRoles($collection)
	{
		$constList = GenerateHelper::getConstListFromCollection($collection, GenerateHelper::PREFIX_ROLE);
		$className = $this->dirAlias . SL . GenerateHelper::TYPE_ROLE;
		GenerateHelper::generateEnum($className, $constList);
		return $constList;
	}

	public function generateRules($collection)
	{
		$constList = GenerateHelper::getConstListFromCollection($collection);
		$className = $this->dirAlias . SL . GenerateHelper::TYPE_RULE;
		GenerateHelper::generateEnum($className, $constList);
		return $constList;
	}

}
