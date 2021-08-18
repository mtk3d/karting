<?php

declare(strict_types=1);


namespace Karting\Availability\Infrastructure\Repository;

use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Shared\ResourceId;
use Illuminate\Support\Collection;

class InMemoryResourceRepository implements ResourceRepository
{
    private Collection $resources;

    public function __construct()
    {
        $this->resources = new Collection();
    }

    public function find(ResourceId $id): ResourceItem
    {
        return $this->resources->get($id->id()->toString());
    }

    public function save(ResourceItem $resource): void
    {
        $this->resources->put($resource->id()->toString(), $resource);
    }

    public function findAll(Collection $ids): Collection
    {
        $rawIds = $ids->map(fn (ResourceId $id): string => $id->id()->toString());
        return $this->resources
            ->filter(fn (ResourceItem $item, string $id): bool => $rawIds->contains($id));
    }

    public function saveAll(Collection $resources): void
    {
        $this->resources->push($resources);
    }
}
