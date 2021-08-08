<?php

declare(strict_types=1);

namespace Karting\Shared\Common\Result;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\Result;
use Illuminate\Support\Collection;

final class Success extends Result
{
    /** @var Collection<int, DomainEvent> */
    protected $events;

    /**
     * @param Collection<int, DomainEvent> $events
     */
    public function __construct(Collection $events)
    {
        $this->events = $events;
    }
}
