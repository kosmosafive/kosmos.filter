# Kosmos: Фильтр

## Введение

Модульное решение предоставляет механизм создания полей фильтра,
прием и фильтрацию данных формы, применение модификаций.

В полном виде (но не обязательно) предполагается разработка дополнительного модуля проекта *.filterconfig,
который будет предоставлять возможность конфигурации фильтра и передачу данных клиенту.
Например, типовой фильтр на портале может предполагать отображение видимых \ скрытых (отображаемых по кнопке "показать
все") свойств фильтра,
сами свойства могут быть разбиты на секции \ колонки. Шаблонизатору на основе конфигурации фильтра необходимо передавать
конфигурацию свойств фильтра для рендера.

## Установка

- Установить модуль

### Установка через composer

В composer.json (пример для директории local) проекта добавьте

```json
{
  "require": {
    "wikimedia/composer-merge-plugin": "dev-master"
  },
  "config": {
    "allow-plugins": {
      "wikimedia/composer-merge-plugin": true
    }
  },
  "extra": {
    "merge-plugin": {
      "require": [
        "../bitrix/composer-bx.json",
        "modules/*/composer.json"
      ],
      "recurse": true,
      "replace": true,
      "ignore-duplicates": false,
      "merge-dev": true,
      "merge-extra": false,
      "merge-extra-deep": false,
      "merge-scripts": false
    },
    "installer-paths": {
      "modules/{$name}/": [
        "type:bitrix-d7-module"
      ]
    }
  }
}
```

## Использование

### Пример использования

```php
use Bitrix\Main\UserTable;
use Kosmos\Filter;
use Kosmos\Filter\ValueObject\FormData;

$query = UserTable::query();

$fieldCollection = (new Filter\Field\FieldCollection())
    ->add(
        new Filter\Field\PositiveInteger(
            new Filter\FieldConfig\Simple(
                new Filter\FieldConfig\Property\Single('ID'),
                'ID'
            )
        )
    )
    ->add(
        new Filter\Field\Boolean(
            new Filter\FieldConfig\Simple(
                new Filter\FieldConfig\Property\Single('ACTIVE'),
                'ACTIVE'
            )
        )
    )
    ->add(
        new Filter\Field\Text(
            new Filter\FieldConfig\Simple(
                new Filter\FieldConfig\Property\Single('NAME'),
                'NAME'
            )
        )
    );

$formData = new FormData(...);
$fieldCollection->setFormData($formData);
(new Filter\QueryBuilder\ORM($query))->apply($fieldCollection, $formData);
```

### Сущности

#### Field (Поле)

Сущность, описывающая поле фильтра. Примеры полей: булево, положительное целое, селектор выбора, функция, пользователь.
Хранит конфигурацию поля (FieldConfig), значение поля.
Отвечает за нахождение, фильтрацию и нормализацию данных поля в переданных данных формы.
По необходимости поле может содержать дополнительный набор параметров.
Например, поле выбора периода позволяет указать минимальную и максимальную даты для выбора; указать доступность выбора
даты или даты и времени.

#### FieldConfig (Конфигурация поля)

Конфигурация поля хранит информацию о Свойстве (Property), идентификаторе поля.

#### Property (Свойство)

Отвечает за хранение информации о поле(-ях) в запросе (читай: название поля или префикс, используемый при построении
запроса).

#### QueryBuilder (Строитель запроса)

Для работы с конкретной реализацией построения запроса реализуется свой строитель.
Например, могут быть реализованы: строитель ORM, строитель Elasticsearch, строитель ClickHouse.
Принимает коллекцию полей и данные формы.
Находит обработчик для полей и применяет требуемые модификации.
Например, строитель ORM хранит объект запроса, который обогащается по мере применения модификаций.

#### HandlerConfig (Конфигурация обработчика)

Хранит информацию об обработчике поля (Handler) и классе поля, которое обрабатывает.

#### Handler (Обработчик)

Принимает строителя запроса, поле и данные формы. Применяет необходимые модификации на основе полученных данных.
Обработчик может описывать различную логику. 
Например, эквивалентность, частичное содержание, промежуток.

### Расширение функционала

Собственные сущности создаются в рамках собственного модуля путем реализации соответствующего интерфейса или наследования базового класса.

Для поддержки кастомных полей необходимо определить обработчик поля.
Сделать это можно с помощью события модуля onCreateHandlerCollection, в ответе которого в ключе handlerConfig вернуть одну \ несколько конфигураций.

```php
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Kosmos\Filter\Handler;
use Kosmos\Sample\Domain\Filter\Field;
use Kosmos\Sample\Domain\Filter\Handler as SampleHandler;

public static function onCreateHandlerCollection(Event $event): EventResult
{
    return new EventResult(
        EventResult::SUCCESS,
        [
            'handlerConfig' => [
                new Handler\HandlerConfig(new SampleHandler\ORM\Role(), Field\Role::class),
            ]
        ]
    );
}
```