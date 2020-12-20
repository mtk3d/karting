<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Application\Command\ReserveResource;
use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Domain\ResourceUnavailableException;
use App\Shared\Common\DomainEventDispatcher;

class ReserveResourceHandler
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
    public function handle(ReserveResource $reserveResource): void
    {
        /** @var ResourceItem $resource */
        $resource = $this->resourceRepository->find($reserveResource->id());
        $result = $resource->reserve($reserveResource->period());

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }
}
