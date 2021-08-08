<?php

declare(strict_types=1);


namespace Karting\Availability\Infrastructure\Repository;

use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Shared\ResourceId;
use Illuminate\Support\Collection;

class InMemoryResourceRepository implements ResourceRepository
{
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new Collection();
    }

    public function find(ResourceId $id): ResourceItem
    {
        return $this->reservations->get((string)$id);
    }

    public function save(ResourceItem $resource): void
    {
        $this->reservations->put((string)$resource->getId(), $resource);
    }
}
