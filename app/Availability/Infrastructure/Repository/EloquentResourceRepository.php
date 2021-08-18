<?php

declare(strict_types=1);

namespace Karting\Availability\Infrastructure\Repository;

use Illuminate\Support\Collection;
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

    public function findAll(Collection $ids): Collection
    {
        $rawIds = $ids->map(fn (ResourceId $id): string => $id->id()->toString());
        return ResourceItem::whereIn('uuid', $rawIds)->get();
    }

    public function saveAll(Collection $resources): void
    {
        $resources->each(function (ResourceItem $item): void {
            $item->save();
        });
    }
}
