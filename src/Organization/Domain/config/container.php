<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Services\\OrganizationServiceInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Services\\OrganizationService',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\OrganizationRepositoryInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Repositories\\Eloquent\\OrganizationRepository',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Services\\UserServiceInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Services\\UserService',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\UserRepositoryInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Repositories\\Eloquent\\UserRepository',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Services\\TypeServiceInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Services\\TypeService',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\TypeRepositoryInterface' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Repositories\\Eloquent\\TypeRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Entities\\OrganizationEntity' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\OrganizationRepositoryInterface',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Entities\\UserEntity' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\UserRepositoryInterface',
		'ZnSandbox\\Sandbox\\Organization\\Domain\\Entities\\TypeEntity' => 'ZnSandbox\\Sandbox\\Organization\\Domain\\Interfaces\\Repositories\\TypeRepositoryInterface',
	],
];