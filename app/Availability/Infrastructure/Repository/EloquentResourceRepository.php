<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Repository;

use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceRepository;
use App\Shared\ResourceId;

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
