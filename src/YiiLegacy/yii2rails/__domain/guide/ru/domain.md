Домен
=====

Каждый домен содержит группу связанных и родственных сущностей.

Например, домен пользователя содержит сервисы

* регистрация
* восстановление пароля
* аутентификация

Например, в домене банк, есть сущности

 * карта
 * банк
 
где карта может содержать информацию о банке.

## Цель

* Обединить родственные сущности в единое пространство.
* Предоставить глобальный доступ к функционалу.
* Инкапсулировать небезопасный функционал.
* решить архитектурный вопрос

## Особенности

* Домен - это пучок сервисов
* Домен - это независимый пакет
* Работает как контейнер для объектов
* Репозитории и сервисы создаются тогда, когда они действительно нужны
* В пределах домена допускается высокая связность сущностей
* Домены располагаются в папке `domain`
* Имеет единственный экземпляр
* домен предоставляет клиентскому коду интерфейсы своих сервисов
* не должен зависеть от приложений и модулей, но может зависеть от стороннего домена
* может иметь несколько версий

## Структура

Домен имеет в своем распоряжении:

* хранилища
* сервисы
* фабрики
* сущности
* и много других вещей, которые мы обычно прячем в приложенях и модулях

## Конфигурация

Объявлять домены можно в файле конфигурации:

```
common\config\domains.php
```

Для своих нужд можете переобъявлять свои домены в конфиге:

```
common\config\domains-local.php
```

эта конфига не включена в GIT.

Для хранилищ и сервисов используются общие приципы:

Для сервиса и хранилища назначается свойство id и domen.

id - это унильное имя в пределах типа (хранилище или сервис).

domain - домен, содержащий в себе сервисы, хранилища и фабрики.

Использование контейнера:

```php
'qr' => [
	'class' => 'yii2rails\domain\Domain',
	'path' => 'yii2bundle\qr\domain',
	'container' => [
		'yii2bundle\qr\domain\entities\QrCacheEntity' => 'yii2bundle\qr\domain\entities\QrEntity',
	],
	'repositories' => [
		'generator' => Driver::FILE,
		'qrCache' => Driver::ACTIVE_RECORD,
	],
	'services' => [
		'generator',
	],
],
```

Принцип работы назначений аналогичен следующему:

```php
Yii::$container->set('yii2bundle\qr\domain\entities\QrCacheEntity', 'yii2bundle\qr\domain\entities\QrEntity');
```

## Пример кода

### Использование

Обратиться к объекту домена:

```php
App::$domain->geo;
```

Обратиться к объекту сервиса:

```php
App::$domain->geo->city;
```

Вызвать метод сервиса:

```php
$allCities = \App::$domain->geo->city->all();
```

Обратиться к объекту хранилища:

```php
\App::$domain->geo->repositories->city
```

Вызвать метод хранилища:

```php
$allCities = \App::$domain->geo->repositories->city->all();
```
Внутри класса сервиса и хранилища можно обращаться к ресурсам домена так:

```php
$allCities = $this->domain->service->city->all();
```

Конфиг домена имеет несколько свойств:

* class - имя класса домена
* id - имя объекта домена
* path - путь до папки домена
* defaultDriver - драйвер хранилища по умолчанию

### Создание

Так же, можно создать кастомный класс домена.
Создавать его следует в корневой папке домена.
Наследовать неоходимо от базового класса:

```php
namespace api\v4\modules\geo;

use common\ddd\Domain as DddDomain;

class Domain extends DddDomain
{
	
}
```

Можно указать дополнительные параметры:

```php
namespace api\v4\modules\geo;

use common\ddd\Domain as DddDomain;

class Domain extends DddDomain {
	public $id = 'geo';
	public $path = 'api\v4\modules\geo';
	public $defaultDriver = 'ar';
}
```

В таком случае, конфиг будет выглядеть так:

```php
return [
	'components' => [
		'geo' => [
			'class' => 'api\v4\modules\geo\Domain',
			'repositories' => [
				'region',
				'city',
				'country',
				'currency',
			],
			'services' => [
				'region',
				'city',
				'country',
				'currency',
			],
		],
	],
];
```

В кастомном классе домена, параметры path, defaultDriver и id необязательные, 
они могут быть сгененрированы автоматически.

Домен создает экземпляры сервисов и хранилищ, опираясь на конфигурацию.
Так же, назначает им атрибуты:

* id - имя сервиса или хранилища
* domain - объект текущего домена

## Мультиязычность

Бывают случаи, что мы наследуем домен от домена, и добавляются переводы для новых сущностей.
Чтобы указать дополнительные файлы переводов, надо добавить конфиг в раздел `translations`.

Например, есть домен **профиль** и мы хотим добавить в него сущность **мерчант** и перевод на эту сущность:

```php
'profile' => [
	'class' => Domain::class,
	'path' => 'yii2module\profile\domain\v2',
	'repositories' => [
		'profile',
		'address',
		'merchant' => 'domain\v4\profile\repositories\ar\MerchantRepository',
	'services' => [
		'profile',
		'address',
		'merchant' => 'domain\v4\profile\services\MerchantService',
	],
	'translations' => [
		'profile/merchant' => [
			'basePath' => '@domain/v4/profile/messages',
			'fileMap' => [
				'profile/merchant' => 'merchant.php',
			],
		],
	],
],
```
