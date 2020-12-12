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

    public function __construct(UUID $eventId, ResourceId $resourceId)
    {
        $this->eventId = $eventId;
        $this->resourceId = $resourceId;
    }

    public static function newOne(ResourceId $resourceId): GoCartCreated
    {
        return new GoCartCreated(UUID::random(), $resourceId);
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }
}
