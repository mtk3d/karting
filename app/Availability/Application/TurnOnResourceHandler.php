<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Domain\ResourceUnavailableException;
use App\Shared\Common\DomainEventDispatcher;

class TurnOnResourceHandler
{
    private ResourceRepository $resourceRepository;
    private DomainEventDispatcher $eventDispatcher;

    public function __construct(ResourceRepository $resourceRepository, DomainEventDispatcher $eventDispatcher)
    {
        $this->resourceRepository = $resourceRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(TurnOnResource $turnOnResource): void
    {
        $resource = $this->resourceRepository->find($turnOnResource->id());
        $result = $resource->turnOn();

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }
}
