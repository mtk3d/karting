<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;

class StateChanged implements DomainEvent
{
    private UUID $id;
    private ResourceId $resourceId;
    private int $slots;
    private bool $enabled;

    public function __construct(UUID $id, ResourceId $resourceId, int $slots, bool $enabled)
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
        $this->slots = $slots;
        $this->enabled = $enabled;
    }

    public static function newOne(ResourceId $resourceId, int $slots, bool $enabled): self
    {
        return new self(UUID::random(), $resourceId, $slots, $enabled);
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

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
