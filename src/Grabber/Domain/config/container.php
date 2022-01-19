<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Services\\SiteServiceInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Services\\SiteService',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\SiteRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\SiteRepository',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Services\\PageServiceInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Services\\PageService',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\PageRepositoryInterface' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Repositories\\Eloquent\\PageRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\SiteEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\SiteRepositoryInterface',
		'ZnSandbox\\Sandbox\\Grabber\\Domain\\Entities\\PageEntity' => 'ZnSandbox\\Sandbox\\Grabber\\Domain\\Interfaces\\Repositories\\PageRepositoryInterface',
	],
];