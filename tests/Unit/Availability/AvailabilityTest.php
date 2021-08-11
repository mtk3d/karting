<?php

namespace Tests\Unit\Availability;

use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Application\CreateResourceHandler;
use Karting\Availability\Application\SetStateHandler;
use Karting\Availability\Domain\Slots;
use Karting\Availability\Domain\StateChanged;
use Karting\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use Karting\Shared\Common\InMemoryDomainEventBus;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResource;
use function Tests\Fixtures\aWithdrawnResource;

class AvailabilityTest extends TestCase
{
    private InMemoryResourceRepository $resourceRepository;
    private InMemoryDomainEventBus $eventDispatcher;
    private CreateResourceHandler $createResourceHandler;
    private SetStateHandler $setStateHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->eventDispatcher = new InMemoryDomainEventBus();

        $this->createResourceHandler = new CreateResourceHandler($this->resourceRepository, $this->eventDispatcher);
        $this->setStateHandler = new SetStateHandler($this->resourceRepository, $this->eventDispatcher);
    }

    public function testCreateResource(): void
    {
        $resource = aResource();
        $this->createResourceHandler->handle(new CreateResource($resource->id(), Slots::of(1), true));

        self::assertEquals($resource, $this->resourceRepository->find($resource->id()));
    }

    public function testDisableResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // when
        $this->setStateHandler->handle(new SetState($resource->id(), false));

        // then
        self::assertEquals(
            new StateChanged($this->eventDispatcher->first()->eventId(), $resource->id(), false),
            $this->eventDispatcher->first()
        );

        $resource = aWithdrawnResource($resource->id());
        self::assertEquals($resource, $this->resourceRepository->find($resource->id()));
    }

    public function testEnableResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // when
        $this->setStateHandler->handle(new SetState($resource->id(), true));

        // then
        self::assertEquals(
            new StateChanged($this->eventDispatcher->first()->eventId(), $resource->id(), true),
            $this->eventDispatcher->first()
        );

        $resource = aResource($resource->id());
        self::assertEquals($resource, $this->resourceRepository->find($resource->id()));
    }
}
