<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function dispatch(Command $command)
    {
        return $this->bus->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
