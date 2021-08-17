<?php

declare(strict_types=1);

namespace Karting\Availability\Application;

use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Availability\Domain\ResourceUnavailableException;
use Karting\Shared\Common\DomainEventBus;

class SetStateHandler
{
    public function __construct(
        private ResourceRepository $resourceRepository,
        private DomainEventBus $bus
    ) {
    }

    public function handle(SetState $setState): void
    {
        $resource = $this->resourceRepository->find($setState->id());

        if ($setState->enabled()) {
            $result = $resource->enable();
        } else {
            $result = $resource->disable();
        }

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->bus, 'dispatch']);
    }
}
