<?php

declare(strict_types=1);

namespace Karting\Shared\Common\Result;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\Result;
use Illuminate\Support\Collection;

final class Success extends Result
{
    /**
     * @param Collection<int, DomainEvent> $events
     */
    public function __construct(protected Collection $events)
    {
    }
}
