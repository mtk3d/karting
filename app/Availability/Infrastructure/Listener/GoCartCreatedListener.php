<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Listener;

use App\Availability\Application\Command\CreateResource;
use App\GoCart\GoCartCreated;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class GoCartCreatedListener
{
    private CommandBusInterface $bus;

    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function handle(GoCartCreated $event): void
    {
        $this->bus->dispatch(new CreateResource($event->resourceId(), $event->isAvailable()));
    }
}
