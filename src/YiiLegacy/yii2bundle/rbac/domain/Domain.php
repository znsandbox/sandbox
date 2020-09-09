<?php

namespace yii2bundle\rbac\domain;

use yii2rails\domain\enums\Driver;
use yii2bundle\rbac\domain\repositories\disc\ItemRepository;
use yii2bundle\rbac\domain\repositories\disc\RuleRepository;

/**
 * Class Domain
 * 
 * @package yii2bundle\rbac\domain
 * @property-read \yii2bundle\rbac\domain\interfaces\services\AssignmentInterface $assignment
 * @property-read \yii2bundle\rbac\domain\interfaces\services\ItemInterface $item
 * @property-read \yii2bundle\rbac\domain\interfaces\services\ManagerInterface $manager
 * @property-read \yii2bundle\rbac\domain\interfaces\services\RuleInterface $rule
 * @property-read \yii2bundle\rbac\domain\interfaces\repositories\RepositoriesInterface $repositories
 * @property-read \yii2bundle\rbac\domain\interfaces\services\RoleInterface $role
 * @property-read \yii2bundle\rbac\domain\interfaces\services\ConstInterface $const
 * @property-read \yii2bundle\rbac\domain\interfaces\services\PermissionInterface $permission
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'rule' => [
					'class' => RuleRepository::class,
					//'itemFile' => '@common/data/rbac/items.php',
					'ruleFile' => '@common/data/rbac/rules.php',
					//'defaultRoles' => ['rGuest'],
				],
				'role' => Driver::BRIDGE,
                'permission' => Driver::BRIDGE,
				'const' => Driver::FILE,
				'assignment' => Driver::ACTIVE_RECORD,
				'manager' => Driver::MEMORY,
				'item' => [
					'class' => ItemRepository::class,
					'itemFile' => '@common/data/rbac/items.php',
					//'ruleFile' => '@common/data/rbac/rules.php',
					'defaultRoles' => ['rGuest'],
				],
				'misc' => Driver::DISC,
			], 
			'services' => [
				'rule',
				'role',
				'permission',
				'const',
				'assignment',
				'manager',
				'item'/* => [
					'defaultRoles' => ['rGuest'],
				]*/,
				'misc',
			],
		];
	}
	
}