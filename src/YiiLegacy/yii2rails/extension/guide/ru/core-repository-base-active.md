BaseActiveCoreRepository
===

## Основное

Наследует класс `BaseCoreRepository`.

Обеспечивает стандартный интерфейс `CrudInterface`.

То есть обладает полным набором методов для обеспечения CRUD.

## Пример

```php
use yii2rails\extension\core\domain\repositories\base\BaseActiveCoreRepository;

class CityRepository extends BaseActiveCoreRepository {

	public $version = 1;
	public $point = 'city';
	
}
```

Используем в клиентском коде как обычно:

```php
$query = Query::forge();
$query->page(3);
$query->with('country');
$responseEntity = App::$domain->geo->repositories->city->all($query);
```
