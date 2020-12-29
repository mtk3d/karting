<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Application\Command\WithdrawResource;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Domain\ResourceUnavailableException;
use App\Shared\Common\DomainEventDispatcher;

class WithdrawResourceHandler
{
    private ResourceRepository $resourceRepository;
    private DomainEventDispatcher $eventDispatcher;

    public function __construct(ResourceRepository $resourceRepository, DomainEventDispatcher $eventDispatcher)
    {
        $this->resourceRepository = $resourceRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(WithdrawResource $withdrawResource): void
    {
        $resource = $this->resourceRepository->find($withdrawResource->id());
        $result = $resource->withdraw();

        if ($result->isFailure()) {
            throw new ResourceUnavailableException($result->reason());
        }

        $this->resourceRepository->save($resource);

        $result->events()->each([$this->eventDispatcher, 'dispatch']);
    }
}
