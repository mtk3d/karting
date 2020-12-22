<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Application\Command\CreateResource;
use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\ResourceRepository;

class CreateResourceHandler
{
    private ResourceRepository $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function handle(CreateResource $createResource): void
    {
        $resource = ResourceItem::of($createResource->id(), $createResource->isAvailable());
        $this->resourceRepository->save($resource);
    }
}
