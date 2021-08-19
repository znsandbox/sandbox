<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Services\\InheritanceServiceInterface' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Services\\InheritanceService',
		'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Repositories\\Eloquent\\InheritanceRepository',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Services\\PersonServiceInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Services\\PersonService',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\PersonRepositoryInterface' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Repositories\\Eloquent\\PersonRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Person\\Domain\\Entities\\InheritanceEntity' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface',
		'ZnSandbox\\Sandbox\\Person2\\Domain\\Entities\\PersonEntity' => 'ZnSandbox\\Sandbox\\Person2\\Domain\\Interfaces\\Repositories\\PersonRepositoryInterface',
	],
];