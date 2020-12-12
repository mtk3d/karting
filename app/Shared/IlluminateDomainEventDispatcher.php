<?php

declare(strict_types=1);


namespace App\Shared;

use Illuminate\Events\Dispatcher;

class IlluminateDomainEventDispatcher implements DomainEventDispatcher
{
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function dispatch(DomainEvent $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
