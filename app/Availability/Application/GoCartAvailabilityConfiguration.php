<?php

declare(strict_types=1);

namespace App\Availability\Application;

use App\Availability\Domain\ResourceRepository;
use App\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use App\Shared\DomainEventDispatcher;
use App\Shared\InMemoryDomainEventDispatcher;

class GoCartAvailabilityConfiguration
{
    public function availabilityFacade(
        ?ResourceRepository $resourceRepository = null,
        ?DomainEventDispatcher $eventDispatcher = null
    ): AvailabilityFacade {
        if ($resourceRepository === null) {
            $resourceRepository = new InMemoryResourceRepository();
        }

        if ($eventDispatcher === null) {
            $eventDispatcher = new InMemoryDomainEventDispatcher();
        }

        $reservationService = new ReservationService($resourceRepository, $eventDispatcher);
        $availabilityService = new AvailabilityService($resourceRepository, $eventDispatcher);

        return new AvailabilityFacade($reservationService, $availabilityService);
    }
}
