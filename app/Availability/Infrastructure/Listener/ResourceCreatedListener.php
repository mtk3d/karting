<?php

declare(strict_types=1);


namespace Karting\Availability\Infrastructure\Listener;

use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Domain\Slots;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\ResourceCreated;

class ResourceCreatedListener
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle(ResourceCreated $event): void
    {
        $this->bus->dispatch(new CreateResource($event->resourceId(), Slots::of($event->slots())));
    }
}
