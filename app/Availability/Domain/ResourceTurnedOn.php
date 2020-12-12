<?php

declare(strict_types=1);


namespace App\Availability\Domain;

use App\Shared\DomainEvent;
use App\Shared\UUID;

class ResourceTurnedOn implements DomainEvent
{
    private UUID $id;
    private ResourceId $resourceId;

    public function __construct(UUID $id, ResourceId $resourceId)
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
    }

    public static function newOne(ResourceId $resourceId): self
    {
        return new self(UUID::random(), $resourceId);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }
}
