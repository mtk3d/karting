<?php

declare(strict_types=1);


namespace Karting\Availability\Domain;

use Illuminate\Support\Collection;
use Karting\Shared\ResourceId;

interface ResourceRepository
{
    public function find(ResourceId $id): ?ResourceItem;
    public function save(ResourceItem $resource): void;

    /**
     * @param Collection<int, ResourceId> $ids
     * @return Collection<int, ResourceItem>
     */
    public function findAll(Collection $ids): Collection;

    /**
     * @param Collection<int, ResourceItem> $resources
     */
    public function saveAll(Collection $resources): void;
}
