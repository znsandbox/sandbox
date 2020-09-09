Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-dashboard
```

Создаем полномочие:

```
oExamlpe
```

Объявляем модуль:

```php
return [
	'modules' => [
		// ...
		'dashboard' => 'yii2bundle\dashboard\console\Module',
		// ...
	],
];
```

Объявляем домен:

```php
return [
	'components' => [
		// ...
		'dashboard' => [
			'class' => 'yii2rails\domain\Domain',
			'path' => 'yii2bundle\dashboard\domain',
			'repositories' => [
				'default',
			],
			'services' => [
				'default',
			],
		],
		// ...
	],
];
```
