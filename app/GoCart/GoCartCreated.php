<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Shared\Common\DomainEvent;
use App\Shared\Common\UUID;
use App\Shared\ResourceId;

class GoCartCreated implements DomainEvent
{
    private UUID $eventId;
    private ResourceId $resourceId;
    private bool $isAvailable;

    public function __construct(UUID $eventId, ResourceId $resourceId, bool $isAvailable)
    {
        $this->eventId = $eventId;
        $this->resourceId = $resourceId;
        $this->isAvailable = $isAvailable;
    }

    public static function newOne(ResourceId $resourceId, bool $isAvailable): GoCartCreated
    {
        return new GoCartCreated(UUID::random(), $resourceId, $isAvailable);
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }
}
