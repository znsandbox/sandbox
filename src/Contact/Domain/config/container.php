<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Contact\\Domain\\Interfaces\\Services\\ValueServiceInterface' => 'ZnSandbox\\Sandbox\\Contact\\Domain\\Services\\ValueService',
		'ZnSandbox\\Sandbox\\Contact\\Domain\\Interfaces\\Repositories\\ValueRepositoryInterface' => 'ZnSandbox\\Sandbox\\Contact\\Domain\\Repositories\\Eloquent\\ValueRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Contact\\Domain\\Entities\\ValueEntity' => 'ZnSandbox\\Sandbox\\Contact\\Domain\\Interfaces\\Repositories\\ValueRepositoryInterface',
	],
];