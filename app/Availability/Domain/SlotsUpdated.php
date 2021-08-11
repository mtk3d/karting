<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;

class SlotsUpdated implements DomainEvent
{
    private UUID $id;
    private ResourceId $resourceId;
    private int $slots;

    public function __construct(UUID $id, ResourceId $resourceId, int $slots)
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
        $this->slots = $slots;
    }

    public static function newOne(ResourceId $resourceId, int $slots): self
    {
        return new self(UUID::random(), $resourceId, $slots);
    }

    public function eventId(): UUID
    {
        return $this->id;
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
