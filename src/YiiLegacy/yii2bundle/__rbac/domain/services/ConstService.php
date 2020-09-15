<?php

namespace yii2bundle\rbac\domain\services;

use yii2rails\domain\services\base\BaseService;
use yii2bundle\rbac\domain\interfaces\services\ConstInterface;

/**
 * Class ConstService
 *
 * @package yii2bundle\rbac\domain\services
 *
 * @property \yii2bundle\rbac\domain\repositories\file\ConstRepository $repository
 * @property \yii2bundle\rbac\domain\Domain $domain
 */
class ConstService extends BaseService implements ConstInterface {

	public function generateAll() {
		$result = [];
		$result['Permissions'] = $this->generatePermissions();
		$result['Roles'] = $this->generateRoles();
		//$result['Rules'] = $this->generateRules();
		return count($result['Permissions']) + count($result['Roles'])/* + count($result['Rules'])*/;
	}

	public function generatePermissions() {
		$permissionCollection = $this->domain->item->getPermissions();
		return $this->repository->generatePermissions($permissionCollection);
	}

	public function generateRoles() {
		$roleCollection = $this->domain->item->getRoles();
		return $this->repository->generateRoles($roleCollection);
	}

	public function generateRules() {
		$ruleCollection = $this->domain->rule->getRules();
		return $this->repository->generateRules($ruleCollection);
	}

}
