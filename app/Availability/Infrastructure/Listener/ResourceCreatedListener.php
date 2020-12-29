<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Listener;

use App\Availability\Application\Command\CreateResource;
use App\Availability\Domain\Slots;
use App\Shared\Common\CommandBus;
use App\Shared\ResourceCreated;

class ResourceCreatedListener
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle(ResourceCreated $event): void
    {
        $this->bus->dispatch(new CreateResource($event->resourceId(), Slots::of($event->slots()), $event->isAvailable()));
    }
}
