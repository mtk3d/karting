<?php

declare(strict_types=1);


namespace Karting\Shared;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;

class ResourceCreated implements DomainEvent
{
    private UUID $eventId;
    private ResourceId $resourceId;
    private int $slots;

    public function __construct(UUID $eventId, ResourceId $resourceId, int $slots)
    {
        $this->eventId = $eventId;
        $this->resourceId = $resourceId;
        $this->slots = $slots;
    }

    public static function newOne(ResourceId $resourceId, int $slots): ResourceCreated
    {
        return new ResourceCreated(UUID::random(), $resourceId, $slots);
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function slots(): int
    {
        return $this->slots;
    }
}
