<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Services\\SiteServiceInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Services\\SiteService',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\SiteRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\SiteRepository',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Services\\PageServiceInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Services\\PageService',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\PageRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\PageRepository',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Services\\QueueServiceInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Services\\QueueService',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\QueueRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\QueueRepository',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\MetumRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\MetumRepository',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\ContentRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\ContentRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\SiteEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\SiteRepositoryInterface',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\PageEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\PageRepositoryInterface',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\QueueEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\QueueRepositoryInterface',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\MetumEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\MetumRepositoryInterface',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\ContentEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\ContentRepositoryInterface',
	],
];