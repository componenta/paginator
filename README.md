# Componenta Paginator

Offset-based paginator value object with array conversion.

Use it for read models and list endpoints that return a slice of results together with navigation metadata.

## Installation

```bash
composer require componenta/paginator
```

## Related Packages

| Package | Why it matters here |
|---|---|
| `componenta/arrayable` | `PaginatorInterface` extends `Arrayable`. |
| `componenta/http-responder` | Responders can serialize pagination results as JSON. |
| `componenta/cycle` | `DataFetcher` can return paginated read-side results. |
| `componenta/cqrs` | Query handlers commonly return `Paginator` from read scenarios. |

## Usage

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

`Paginator` implements `PaginatorInterface`, which extends `Componenta\Arrayable\Arrayable`.

## Array Shape

`toArray()` returns:

- `results`
- `totalCount`
- `limit`
- `offset`
- `currentPage`
- `totalPages`
- `hasNext`
- `hasPrev`
- `range`

`range` is `null` for an empty page. Otherwise it contains one-based result positions for the current slice.

## Unknown Totals

`totalCount` may be `null` for infinite-scroll reads. In that mode:

- `totalPages` is `null`
- `hasNextPage` uses `hasNextPageHint` when provided
- without a hint, `hasNextPage` falls back to `count(results) >= limit`

Fetchers can request one extra row, trim it, and pass an explicit hint for precise next-page detection without running a total-count query.
