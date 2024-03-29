<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use JsonSerializable;
use Karting\Shared\ResourceId;

abstract class ResourceItem implements JsonSerializable
{
    public function __construct(
        private ResourceId $resourceId,
        private bool $reserved
    ) {
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
            'resource_id' => $this->resourceId->toString(),
            'reserved' => $this->reserved
        ];
    }
}
