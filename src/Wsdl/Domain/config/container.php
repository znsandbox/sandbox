<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Services\\RequestServiceInterface' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Services\\RequestService',
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Services\\TransportServiceInterface' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Services\\TransportService',
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\TransportRepositoryInterface' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Eloquent\\TransportRepository',
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\ClientRepositoryInterface' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Wsdl\\ClientRepository',
//		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\ServiceRepositoryInterface' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\File\\ServiceRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Entities\\TransportEntity' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\TransportRepositoryInterface',
		'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Entities\\ServiceEntity' => 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\ServiceRepositoryInterface',
	],
];