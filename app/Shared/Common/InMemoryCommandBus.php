<?php

declare(strict_types=1);

namespace Karting\Shared\Common;

use Illuminate\Support\Collection;

class InMemoryCommandBus implements CommandBus
{
    private Collection $commands;

    public function __construct()
    {
        $this->commands = collect();
    }

    public function dispatch(Command $command)
    {
        $this->commands->push($command);
    }

    public function map(array $map): void
    {
        // Nothing to do
    }

    public function dispatchedCommands(): Collection
    {
        return $this->commands;
    }
}
