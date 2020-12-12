<?php

declare(strict_types=1);

namespace App\Availability\Application;

use App\Availability\Domain\ResourceId;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceUnavailableException;
use App\Shared\DomainEventDispatcher;
use Carbon\CarbonPeriod;

class ReservationService
{
    private ResourceRepository $resourceRepository;
    private DomainEventDispatcher $eventDispatcher;

    public function __construct(ResourceRepository $resourceRepository, DomainEventDispatcher $eventDispatcher)
    {
        $this->resourceRepository = $resourceRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @throws ResourceUnavailableException
     */
    public function reserve(ResourceId $id, CarbonPeriod $period): void
    {
        /** @var ResourceItem $resource */
        $resource = $this->resourceRepository->find($id);
        $result = $resource->reserve($period);

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }
}
