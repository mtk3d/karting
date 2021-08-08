<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

interface DomainEvent
{
    public function eventId(): UUID;
}
