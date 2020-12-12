<?php

declare(strict_types=1);


namespace App\Shared\Common;

interface DomainEvent
{
    public function eventId(): UUID;
}
