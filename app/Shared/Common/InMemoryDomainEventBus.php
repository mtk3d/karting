<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

use Illuminate\Support\Collection;

class InMemoryDomainEventBus implements DomainEventBus
{
    /** @var Collection<string, DomainEvent> */
    private Collection $events;

    public function __construct()
    {
        $this->events = collect();
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->events->put((string)$event->eventId(), $event);
    }

    public function first(): ?DomainEvent
    {
        return $this->events->first();
    }

    public function events(): Collection
    {
        return $this->events;
    }
}
