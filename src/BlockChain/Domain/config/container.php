<?php

return [
	'singletons' => [
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Services\\AddressServiceInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Services\\AddressService',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\AddressRepositoryInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Repositories\\Eloquent\\AddressRepository',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Services\\TransactionServiceInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Services\\TransactionService',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\TransactionRepositoryInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Repositories\\Eloquent\\TransactionRepository',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Services\\SummaryBalanceServiceInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Services\\SummaryBalanceService',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\SummaryBalanceRepositoryInterface' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Repositories\\Eloquent\\SummaryBalanceRepository',
	],
	'entities' => [
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Entities\\AddressEntity' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\AddressRepositoryInterface',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Entities\\TransactionEntity' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\TransactionRepositoryInterface',
		'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Entities\\SummaryBalanceEntity' => 'ZnSandbox\\Sandbox\\BlockChain\\Domain\\Interfaces\\Repositories\\SummaryBalanceRepositoryInterface',
	],
];