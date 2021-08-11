<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

use Illuminate\Events\Dispatcher;

class IlluminateDomainEventBus implements DomainEventBus
{
    public function __construct(private Dispatcher $dispatcher)
    {
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
