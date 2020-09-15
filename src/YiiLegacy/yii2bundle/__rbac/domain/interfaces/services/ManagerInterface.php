<?php

namespace yii2bundle\rbac\domain\interfaces\services;

interface ManagerInterface {

	public function can($rule, $param = null, $allowCaching = true);
	public function checkAccess($userId, $permissionName, $params = []);
	public function isAllow($permissions, $params = [], $userId = null);

}