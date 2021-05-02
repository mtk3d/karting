<?php

declare(strict_types=1);


namespace App\Shared;

use App\Shared\Common\DomainEvent;
use App\Shared\Common\UUID;

class ResourceCreated implements DomainEvent
{
    private UUID $eventId;
    private ResourceId $resourceId;
    private int $slots;
    private bool $isAvailable;

    public function __construct(UUID $eventId, ResourceId $resourceId, int $slots, bool $isAvailable)
    {
        $this->eventId = $eventId;
        $this->resourceId = $resourceId;
        $this->slots = $slots;
        $this->isAvailable = $isAvailable;
    }

    public static function newOne(ResourceId $resourceId, int $slots, bool $isAvailable): ResourceCreated
    {
        return new ResourceCreated(UUID::random(), $resourceId, $slots, $isAvailable);
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

    public function slots(): int
    {
        return $this->slots;
    }
}
