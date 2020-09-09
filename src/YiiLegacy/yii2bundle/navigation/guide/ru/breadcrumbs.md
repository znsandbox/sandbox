Хлебные крошки (breadcrumbs)
====================

Создание пунктов меню "Хлебные крошки"

```php
App::$domain->navigation->breadcrumbs->create('title');
```

Можно указать ссылку

```php
App::$domain->navigation->breadcrumbs->create('title', 'user/auth');
```

Можно указать адрес перевода вместо текста

```php
App::$domain->navigation->breadcrumbs->create(['main', 'title']);
```

Когда необходимо показывать последний пункт без URL, простой строчкой

```php
App::$domain->navigation->breadcrumbs->removeLastUrl();
```

Метод removeLastUrl принимает true или false, что буквально означает - удалять ли URL из последнего пункта.
По умолчанию параметр равен true.

При создании ссылок всегда указывайте URL, а приложение само решит показывать ли последний пункт без URL.