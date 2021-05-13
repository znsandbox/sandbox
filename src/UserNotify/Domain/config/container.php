<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\HistoryRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\HistoryRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TypeRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\TypeRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TypeI18nRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\TypeI18nRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\ActivityRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\ActivityRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\SettingRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\SettingRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\HistoryServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\HistoryService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\MyHistoryServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\MyHistoryService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\ActivityServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\ActivityService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\NotifyServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\NotifyService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\TypeServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\TypeService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\SettingServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\SettingService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\TransportServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\TransportService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TransportRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\TransportRepository',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Services\\TypeTransportServiceInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Services\\TypeTransportService',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TypeTransportRepositoryInterface' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Repositories\\Eloquent\\TypeTransportRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Entities\\TypeEntity' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TypeRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Entities\\NotifyEntity' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\HistoryRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Entities\\SettingEntity' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\SettingRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Entities\\TransportEntity' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TransportRepositoryInterface',
		'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Entities\\TypeTransportEntity' => 'ZnSandbox\\Sandbox\\UserNotify\\Domain\\Interfaces\\Repositories\\TypeTransportRepositoryInterface',
	],
];