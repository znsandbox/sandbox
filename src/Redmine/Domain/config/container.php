<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\UserServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\UserService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\UserRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\UserRepository',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\ProjectServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\ProjectService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\ProjectRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\ProjectRepository',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\TrackerServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\TrackerService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\TrackerRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\TrackerRepository',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\StatusServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\StatusService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\StatusRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\StatusRepository',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\PriorityServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\PriorityService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\PriorityRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\PriorityRepository',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Services\\IssueServiceInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Services\\IssueService',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\IssueRepositoryInterface' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Repositories\\Eloquent\\IssueRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\UserEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\UserRepositoryInterface',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\ProjectEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\ProjectRepositoryInterface',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\TrackerEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\TrackerRepositoryInterface',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\StatusEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\StatusRepositoryInterface',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\PriorityEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\PriorityRepositoryInterface',
		'ZnSandbox\\Sandbox\\Redmine\\Domain\\Entities\\IssueEntity' => 'ZnSandbox\\Sandbox\\Redmine\\Domain\\Interfaces\\Repositories\\IssueRepositoryInterface',
	],
];