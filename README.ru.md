# Componenta Paginator

Объект значения для постраничной навигации по смещению с преобразованием в массив.

Используйте его для моделей чтения и списочных HTTP-точек, которые возвращают часть результатов вместе с метаданными навигации.

## Установка

```bash
composer require componenta/paginator
```

## Связанные пакеты

| Пакет | Зачем нужен здесь |
|---|---|
| `componenta/arrayable` | `PaginatorInterface` расширяет `Arrayable`, чтобы результат можно было вернуть как массив. |
| `componenta/http-responder` | Ответчик может превратить результат пагинации в JSON-ответ. |
| `componenta/cycle` | `DataFetcher` может возвращать пагинатор для списочных запросов и моделей чтения. |
| `componenta/cqrs` | Обработчики запросов часто возвращают `Paginator` из сценариев стороны чтения. |

## Использование

```php
use Componenta\Stdlib\Paginator;

$page = new Paginator(
    results: $posts,
    limit: 20,
    offset: 40,
    totalCount: 95,
);

$page->currentPage; // 3
$page->totalPages;  // 5
$page->hasNextPage; // true
$page->nextOffset;  // 60
```

`Paginator` реализует `PaginatorInterface`, который расширяет `Componenta\Arrayable\Arrayable`.

## Форма массива

`toArray()` возвращает:

- `results`
- `totalCount`
- `limit`
- `offset`
- `currentPage`
- `totalPages`
- `hasNext`
- `hasPrev`
- `range`

`range` равен `null` для пустой страницы. Иначе он содержит позиции результатов текущего среза, начиная с единицы.

## Неизвестное общее количество

`totalCount` может быть `null` для чтения с бесконечной прокруткой. В этом режиме:

- `totalPages` равен `null`
- `hasNextPage` использует `hasNextPageHint`, если он передан
- без подсказки `hasNextPage` использует запасное правило `count(results) >= limit`

Фетчеры могут запросить одну лишнюю строку, обрезать её и передать явную подсказку, чтобы точно определить следующую страницу без запроса общего количества.
