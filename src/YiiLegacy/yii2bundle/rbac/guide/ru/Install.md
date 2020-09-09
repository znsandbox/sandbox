Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-rbac
```

Объявляем домен:

```php
return [
	'components' => [
		// ...
		'rbac' => 'yii2bundle\rbac\domain\Domain',
		// ...
	],
];
```
