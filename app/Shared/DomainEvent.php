<?php

declare(strict_types=1);


namespace App\Shared;

interface DomainEvent
{
    public function eventId(): UUID;
}
