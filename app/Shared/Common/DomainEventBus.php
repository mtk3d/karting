<?php

declare(strict_types=1);

namespace Karting\Shared\Common;

interface DomainEventBus
{
    public function dispatch(DomainEvent $event): void;
}
