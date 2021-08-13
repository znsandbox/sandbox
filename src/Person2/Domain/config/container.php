<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Services\\InheritanceServiceInterface' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Services\\InheritanceService',
		'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Repositories\\Eloquent\\InheritanceRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Person\\Domain\\Entities\\InheritanceEntity' => 'ZnSandbox\\Sandbox\\Person\\Domain\\Interfaces\\Repositories\\InheritanceRepositoryInterface',
	],
];