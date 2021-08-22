<?php

declare(strict_types=1);


namespace Karting\Availability\Application;

use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Domain\ReservationFailed;
use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Availability\Domain\ResourceUnavailableException;
use Karting\Shared\Common\DomainEventBus;

class ReserveResourceHandler
{
    public function __construct(
        private ResourceRepository $resourceRepository,
        private DomainEventBus $bus
    ) {
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
            $this->bus->dispatch(ReservationFailed::newOne($resource->id(), $reserveResource->period(), $reserveResource->reservationId()));
        } else {
            $this->resourceRepository->save($resource);
            $result->events()->each([$this->bus, 'dispatch']);
        }
    }
}
