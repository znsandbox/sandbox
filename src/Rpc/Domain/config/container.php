<?php

return [
	'definitions' => [],
	'singletons' => [
		'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Services\\MethodServiceInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Services\\MethodService',
		'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Repositories\\MethodRepositoryInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Repositories\\Eloquent\\MethodRepository',
        'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Services\\VersionHandlerServiceInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Services\\VersionHandlerService',
        'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Repositories\\VersionHandlerRepositoryInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Repositories\\Eloquent\\VersionHandlerRepository',
		'ZnLib\\Rpc\\Symfony4\\Web\\Controllers\\RpcController' => 'ZnSandbox\\Sandbox\\Rpc\\Symfony4\\Web\\Controllers\\RpcController',
		'ZnLib\\Rpc\\Symfony4\\Web\\Controllers\\DocsController' => 'ZnSandbox\\Sandbox\\Rpc\\Symfony4\\Web\\Controllers\\DocsController',
		'ZnLib\\Rpc\\Symfony4\\Web\\Controllers\\DefaultController' => 'ZnSandbox\\Sandbox\\Rpc\\Symfony4\\Web\\Controllers\\DefaultController',
		'ZnLib\\Rpc\\Domain\\Interfaces\\Repositories\\DocsRepositoryInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Repositories\\File\\DocsRepository',
		'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Services\\SettingsServiceInterface' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Services\\SettingsService',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Rpc\\Domain\\Entities\\MethodEntity' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Repositories\\MethodRepositoryInterface',
        'ZnSandbox\\Sandbox\\Rpc\\Domain\\Entities\\VersionHandlerEntity' => 'ZnSandbox\\Sandbox\\Rpc\\Domain\\Interfaces\\Repositories\\VersionHandlerRepositoryInterface',
	],
];