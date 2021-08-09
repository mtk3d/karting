<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

use Illuminate\Events\Dispatcher;

class IlluminateDomainEventBus implements DomainEventBus
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
