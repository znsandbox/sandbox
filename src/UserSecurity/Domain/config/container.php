<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Services\\VersionHandlerServiceInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Services\\VersionHandlerService',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\VersionHandlerRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Repositories\\Eloquent\\VersionHandlerRepository',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Services\\PasswordHistoryServiceInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Services\\PasswordHistoryService',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\PasswordHistoryRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Repositories\\Eloquent\\PasswordHistoryRepository',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Services\\PasswordValidatorServiceInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Services\\PasswordValidatorService',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Services\\PasswordBlacklistServiceInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Services\\PasswordBlacklistService',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\PasswordBlacklistRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Repositories\\Eloquent\\PasswordBlacklistRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Entities\\VersionHandlerEntity' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\VersionHandlerRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Entities\\PasswordHistoryEntity' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\PasswordHistoryRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Entities\\PasswordBlacklistEntity' => 'ZnSandbox\\Sandbox\\UserSecurity\\Domain\\Interfaces\\Repositories\\PasswordBlacklistRepositoryInterface',
	],
];