<?php

namespace yii2bundle\rbac\domain\repositories\memory;

use yii\helpers\ArrayHelper;
use yii2rails\domain\repositories\BaseRepository;
use Yii;
use yii2bundle\rbac\domain\enums\RbacPermissionEnum;
use yii2bundle\rbac\domain\interfaces\repositories\ManagerInterface;

/**
 * Class ManagerRepository
 *
 * @package yii2bundle\rbac\domain\repositories\memory
 *
 * @property \yii2bundle\rbac\domain\Domain $domain
 */
class ManagerRepository extends BaseRepository implements ManagerInterface {
	
	public function isGuestOnlyAllowed($rule) {
		return $this->isInRules(RbacPermissionEnum::GUEST, $rule) && !Yii::$app->user->isGuest;
	}

	public function isAuthOnlyAllowed($rule) {
		return $this->isInRules(RbacPermissionEnum::AUTHORIZED, $rule) && Yii::$app->user->isGuest;
	}

	private function isInRules($name, $rules) {
		return in_array($name, ArrayHelper::toArray($rules));
	}
	
}