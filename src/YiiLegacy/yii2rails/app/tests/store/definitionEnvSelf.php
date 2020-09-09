<?php 

return [
	'commands' => [],
	'filters' => [
		[
			'class' => 'yii2rails\\app\\domain\\filters\\env\\LoadConfig',
			'paths' => [
				'vendor/yii2rails/yii2-app/tests/_application_test/common/config',
			],
		],
		'yii2rails\\app\\domain\\filters\\env\\YiiEnv',
	],
];