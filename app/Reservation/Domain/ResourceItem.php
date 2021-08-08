<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use JsonSerializable;
use Karting\Shared\ResourceId;

class ResourceItem implements JsonSerializable
{
    private ResourceId $resourceId;
    private bool $reserved;

    public function __construct(ResourceId $resourceId, bool $reserved)
    {
        $this->resourceId = $resourceId;
        $this->reserved = $reserved;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function reserved(): bool
    {
        return $this->reserved;
    }

    public function reserve(): void
    {
        $this->reserved = true;
    }

    public function jsonSerialize()
    {
        return [
            'resource_id' => $this->resourceId->id()->toString(),
            'reserved' => $this->reserved
        ];
    }
}
