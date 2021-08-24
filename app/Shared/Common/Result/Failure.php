<?php

declare(strict_types=1);

namespace Karting\Shared\Common\Result;

use Illuminate\Support\Collection;
use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\Result;

final class Failure extends Result
{
    /**
     * @param Collection<int, DomainEvent> $events
     */
    public function __construct(protected string $reason, protected Collection $events)
    {
    }
}
