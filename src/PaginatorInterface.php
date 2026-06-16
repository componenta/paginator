<?php

declare(strict_types=1);

namespace Componenta\Stdlib;

use Componenta\Arrayable\Arrayable;

/**
 * @template T
 */
interface PaginatorInterface extends Arrayable
{
    /**
     * @var array<array-key, T>
     */
    public array $results { get; }

    /**
     * @var int<1, max>
     */
    public int $limit { get; }

    /**
     * @var int<0, max>
     */
    public int $offset { get; }

    /**
     * Null means the total number of available items is unknown.
     *
     * @var int<0, max>|null
     */
    public ?int $totalCount { get; }

    public bool $hasNextPage { get; }

    public bool $hasPrevPage { get; }

    /**
     * @var int<0, max>|null
     */
    public ?int $nextOffset { get; }

    /**
     * @var int<0, max>|null
     */
    public ?int $prevOffset { get; }

    /**
     * @var int<1, max>
     */
    public int $currentPage { get; }

    /**
     * @var int<0, max>|null
     */
    public ?int $totalPages { get; }

    /**
     * @var array{int<1, max>, int<1, max>}|null
     */
    public ?array $range { get; }
}
