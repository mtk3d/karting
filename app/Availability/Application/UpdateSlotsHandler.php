<?php

declare(strict_types=1);

namespace Karting\Availability\Application;

use Karting\Availability\Application\Command\UpdateSlots;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Shared\Common\DomainEventBus;

class UpdateSlotsHandler
{
    private ResourceRepository $repository;
    private DomainEventBus $bus;

    public function __construct(ResourceRepository $repository, DomainEventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function handle(UpdateSlots $updateSlots): void
    {
        $resource = $this->repository->find($updateSlots->id());
        $result = $resource->setSlots($updateSlots->slots());
        $this->repository->save($resource);

        $result->events()->each([$this->bus, 'dispatch']);
    }
}
