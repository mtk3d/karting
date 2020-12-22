<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Listener;

use App\Availability\Application\Command\CreateResource;
use App\GoCart\GoCartCreated;
use App\Shared\Common\CommandBus;

class GoCartCreatedListener
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle(GoCartCreated $event): void
    {
        $this->bus->dispatch(new CreateResource($event->resourceId(), $event->isAvailable()));
    }
}
