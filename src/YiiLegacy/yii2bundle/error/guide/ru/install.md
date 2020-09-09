Установка
===

Устанавливаем зависимость:

```
composer require yii2module/yii2-error
```

Объявляем в `common` модуль:

```php
return [
	'modules' => [
		// ...
		'error' => 'yii2bundle\error\module\Module',
		// ...
	],
];
```

Объявляем `backend\config\main` и `frontend\config\main` конфиг:

```php
'errorHandler' => [
	'errorAction' => 'error/error/error',
],
```

Настраиваем контейнер в `common\config\bootstrap`:

```php
Yii::$container->set('yii\web\ErrorHandler', [
	'class' => 'yii2bundle\error\domain\web\ErrorHandler',
]);
```
