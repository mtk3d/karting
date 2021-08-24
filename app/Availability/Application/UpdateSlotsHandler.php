<?php

declare(strict_types=1);

namespace Karting\Availability\Application;

use Illuminate\Support\Collection;
use Karting\Availability\Application\Command\UpdateSlots;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Availability\Domain\Slots;
use Karting\Shared\Common\DomainEventBus;

class UpdateSlotsHandler
{
    public function __construct(
        private ResourceRepository $repository,
        private DomainEventBus $bus
    ) {
    }

    public function handle(UpdateSlots $updateSlots): void
    {
        $resource = $this->repository->find($updateSlots->id());
        $result = $resource->setSlots(Slots::of($updateSlots->slots()));
        $this->repository->save($resource);

        $result->events()->each([$this->bus, 'dispatch']);
    }
}
