<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\RoleServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\RoleService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\RoleRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\Eloquent\\RoleRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\ManagerServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\ManagerService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\InheritanceServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\InheritanceService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\Eloquent\\InheritanceRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\ManagerRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\File\\ManagerRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\ItemServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\ItemService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\ItemRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\Eloquent\\ItemRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\PermissionServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\PermissionService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\PermissionRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\Eloquent\\PermissionRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\RoleEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\RoleRepositoryInterface',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\InheritanceEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\ItemEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\ItemRepositoryInterface',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\PermissionEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\PermissionRepositoryInterface',
	],
];