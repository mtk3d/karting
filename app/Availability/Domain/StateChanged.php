<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;

class StateChanged implements DomainEvent
{
    public function __construct(private UUID $id, private ResourceId $resourceId, private bool $enabled)
    {
    }

    public static function newOne(ResourceId $resourceId, bool $enabled): self
    {
        return new self(UUID::random(), $resourceId, $enabled);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
