<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Repository;

use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceId;
use App\Availability\Domain\ResourceRepository;

class EloquentResourceRepository implements ResourceRepository
{
    public function find(ResourceId $id): ResourceItem
    {
        return ResourceItem::find($id->id());
    }

    public function save(ResourceItem $resource): void
    {
        $resource->push();
    }
}
