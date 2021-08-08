<?php

declare(strict_types=1);

namespace Karting\Availability\Infrastructure\Repository;

use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Shared\ResourceId;

class EloquentResourceRepository implements ResourceRepository
{
    public function find(ResourceId $id): ResourceItem
    {
        return ResourceItem::where('uuid', $id->id())->first();
    }

    public function save(ResourceItem $resource): void
    {
        $resource->push();
    }
}
