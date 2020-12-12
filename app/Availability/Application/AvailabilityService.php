<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceAvailabilityException;
use App\Availability\Domain\ResourceId;
use App\Availability\Domain\ResourceRepository;
use App\Shared\DomainEventDispatcher;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class AvailabilityService
{
    private ResourceRepository $resourceRepository;
    private DomainEventDispatcher $eventDispatcher;

    public function __construct(ResourceRepository $resourceRepository, DomainEventDispatcher $eventDispatcher)
    {
        $this->resourceRepository = $resourceRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createResource(ResourceId $id): void
    {
        $resource = ResourceItem::of($id);

        $this->resourceRepository->save($resource);
    }

    public function withdrawResource(ResourceId $id): void
    {
        $resource = $this->resourceRepository->find($id);
        $result = $resource->withdraw();

        if ($result->isFailure()) {
            throw new ResourceAvailabilityException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }

    public function turnOnResource(ResourceId $id): void
    {
        $resource = $this->resourceRepository->find($id);
        $result = $resource->turnOn();

        if ($result->isFailure()) {
            throw new ResourceAvailabilityException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }
}
