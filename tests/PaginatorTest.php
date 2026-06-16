<?php

declare(strict_types=1);

namespace Componenta\Stdlib\Tests;

use Componenta\Stdlib\Paginator;

it('exposes offset pagination metadata from known total count', function (): void {
    $paginator = new Paginator(['a', 'b'], limit: 2, offset: 2, totalCount: 5);

    expect($paginator->results)->toBe(['a', 'b'])
        ->and($paginator->currentPage)->toBe(2)
        ->and($paginator->totalPages)->toBe(3)
        ->and($paginator->hasNextPage)->toBeTrue()
        ->and($paginator->hasPrevPage)->toBeTrue()
        ->and($paginator->nextOffset)->toBe(4)
        ->and($paginator->prevOffset)->toBe(0)
        ->and($paginator->range)->toBe([3, 4]);
});

it('normalizes invalid limit offset and total count boundaries', function (): void {
    $paginator = new Paginator([], limit: 0, offset: -10, totalCount: -5);

    expect($paginator->limit)->toBe(1)
        ->and($paginator->offset)->toBe(0)
        ->and($paginator->totalCount)->toBe(0)
        ->and($paginator->hasNextPage)->toBeFalse()
        ->and($paginator->range)->toBeNull();
});
