<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\RoleServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\RoleService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\RoleRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\Eloquent\\RoleRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\ManagerServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\ManagerService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Services\\InheritanceServiceInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Services\\InheritanceService',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\File\\InheritanceRepository',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\ManagerRepositoryInterface' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Repositories\\File\\ManagerRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\RoleEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\RoleRepositoryInterface',
		'ZnSandbox\\Sandbox\\Casbin\\Domain\\Entities\\InheritanceEntity' => 'ZnSandbox\\Sandbox\\Casbin\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface',
	],
];