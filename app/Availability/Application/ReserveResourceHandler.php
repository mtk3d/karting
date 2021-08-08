<?php

declare(strict_types=1);


namespace Karting\Availability\Application;

use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Availability\Domain\ResourceUnavailableException;
use Karting\Shared\Common\DomainEventBus;

class ReserveResourceHandler
{
    private ResourceRepository $resourceRepository;
    private DomainEventBus $bus;

    public function __construct(ResourceRepository $resourceRepository, DomainEventBus $bus)
    {
        $this->resourceRepository = $resourceRepository;
        $this->bus = $bus;
    }

    /**
     * @throws ResourceUnavailableException
     */
    public function handle(ReserveResource $reserveResource): void
    {
        /** @var ResourceItem $resource */
        $resource = $this->resourceRepository->find($reserveResource->id());
        $result = $resource->reserve($reserveResource->period(), $reserveResource->reservationId());

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->bus, 'dispatch']);
    }
}
