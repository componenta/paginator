<?php

declare(strict_types=1);

namespace Componenta\Stdlib;

/**
 * Offset-based paginator implementation.
 *
 * When totalCount is null, hasNextPage can use a hint from callers that fetch
 * one extra row. If omitted, it falls back to the historical count(results) >=
 * limit heuristic.
 *
 * @template T
 * @implements PaginatorInterface<T>
 */
final class Paginator implements PaginatorInterface
{
    /**
     * @var array<array-key, T>
     */
    public readonly array $results;
    public readonly int  $limit;
    public readonly int  $offset;
    public readonly ?int $totalCount;

    public bool $hasNextPage {
        get {
            if ($this->isEmpty()) {
                return false;
            }

            if ($this->hasNextPageHint !== null) {
                return $this->hasNextPageHint;
            }

            if ($this->totalCount === null) {
                return count($this->results) >= $this->limit;
            }

            return ($this->offset + $this->limit) < $this->totalCount;
        }
    }

    public bool $hasPrevPage {
        get => $this->offset > 0;
    }

    public ?int $nextOffset {
        get => $this->hasNextPage
            ? $this->offset + $this->limit
            : null;
    }

    public ?int $prevOffset {
        get => $this->hasPrevPage
            ? max(0, $this->offset - $this->limit)
            : null;
    }

    public int $currentPage {
        get => (int) floor($this->offset / $this->limit) + 1;
    }

    public ?int $totalPages {
        get => $this->totalCount === null
            ? null
            : (int) ceil($this->totalCount / $this->limit);
    }

    public ?array $range {
        get => $this->isEmpty()
            ? null
            : [
                $this->offset + 1,
                $this->offset + count($this->results),
            ];
    }

    /**
     * @param array<array-key, T> $results
     */
    public function __construct(
        array $results,
        int $limit = 10,
        int $offset = 0,
        ?int $totalCount = null,
        private readonly ?bool $hasNextPageHint = null,
    ) {
        $this->results    = $results;
        $this->limit      = max(1, $limit);
        $this->offset     = max(0, $offset);
        $this->totalCount = $totalCount !== null ? max(0, $totalCount) : null;
    }

    public function isEmpty(): bool
    {
        return $this->results === [];
    }

    public function toArray(): array
    {
        return [
            'results'     => $this->results,
            'totalCount'  => $this->totalCount,
            'limit'       => $this->limit,
            'offset'      => $this->offset,
            'currentPage' => $this->currentPage,
            'totalPages'  => $this->totalPages,
            'hasNext'     => $this->hasNextPage,
            'hasPrev'     => $this->hasPrevPage,
            'range'       => $this->range,
        ];
    }
}
