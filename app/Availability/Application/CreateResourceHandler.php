<?php

declare(strict_types=1);


namespace Karting\Availability\Application;

use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\ResourceRepository;

class CreateResourceHandler
{
    private ResourceRepository $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function handle(CreateResource $createResource): void
    {
        $resource = ResourceItem::of(
            $createResource->id(),
            $createResource->slots(),
            $createResource->enabled()
        );

        $this->resourceRepository->save($resource);
    }
}
