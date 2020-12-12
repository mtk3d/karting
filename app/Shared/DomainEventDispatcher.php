<?php

declare(strict_types=1);

namespace App\Shared;

interface DomainEventDispatcher
{
    public function dispatch(DomainEvent $event): void;
}
