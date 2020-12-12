<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Repository;

use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceRepository;
use App\Shared\ResourceId;
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
