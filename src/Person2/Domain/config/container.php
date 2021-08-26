<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\InheritanceServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\InheritanceService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Repositories\\Eloquent\\InheritanceRepository',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\PersonServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\PersonService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\PersonRepositoryInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Repositories\\Eloquent\\PersonRepository',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\MyPersonServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\MyPersonService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\ContactServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\ContactService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\MyContactServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\MyContactService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\MyChildServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\MyChildService',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Entities\\InheritanceEntity' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Entities\\PersonEntity' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\PersonRepositoryInterface',
	],
];