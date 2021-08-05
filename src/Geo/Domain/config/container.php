<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Services\\CountryServiceInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Services\\CountryService',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\CountryRepositoryInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Repositories\\Eloquent\\CountryRepository',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Services\\RegionServiceInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Services\\RegionService',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\RegionRepositoryInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Repositories\\Eloquent\\RegionRepository',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Services\\LocalityServiceInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Services\\LocalityService',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\LocalityRepositoryInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Repositories\\Eloquent\\LocalityRepository',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Services\\CurrencyServiceInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Services\\CurrencyService',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\CurrencyRepositoryInterface' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Repositories\\Eloquent\\CurrencyRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Entities\\CountryEntity' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\CountryRepositoryInterface',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Entities\\RegionEntity' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\RegionRepositoryInterface',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Entities\\LocalityEntity' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\LocalityRepositoryInterface',
		'ZnSandbox\\Sandbox\\Geo\\Domain\\Entities\\CurrencyEntity' => 'ZnSandbox\\Sandbox\\Geo\\Domain\\Interfaces\\Repositories\\CurrencyRepositoryInterface',
	],
];