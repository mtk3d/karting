<?php

namespace Tests\Unit\Availability;

use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Application\Command\TurnOnResource;
use Karting\Availability\Application\Command\WithdrawResource;
use Karting\Availability\Application\CreateResourceHandler;
use Karting\Availability\Application\SetStateHandler;
use Karting\Availability\Application\TurnOnResourceHandler;
use Karting\Availability\Application\WithdrawResourceHandler;
use Karting\Availability\Domain\ResourceTurnedOn;
use Karting\Availability\Domain\ResourceUnavailableException;
use Karting\Availability\Domain\ResourceWithdrawn;
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

        $this->createResourceHandler = new CreateResourceHandler($this->resourceRepository);
        $this->setStateHandler = new SetStateHandler($this->resourceRepository, $this->eventDispatcher);
    }

    public function testCreateResource(): void
    {
        $resource = aResource();
        $this->createResourceHandler->handle(new CreateResource($resource->getId(), Slots::of(1)));

        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testDisableResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // when
        $this->setStateHandler->handle(new SetState($resource->getId(), false));

        // then
        self::assertEquals(
            new StateChanged($this->eventDispatcher->first()->eventId(), $resource->getId(), false),
            $this->eventDispatcher->first()
        );

        $resource = aWithdrawnResource($resource->getId());
        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testEnableResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // when
        $this->setStateHandler->handle(new SetState($resource->getId(), true));

        // then
        self::assertEquals(
            new StateChanged($this->eventDispatcher->first()->eventId(), $resource->getId(), true),
            $this->eventDispatcher->first()
        );

        $resource = aResource($resource->getId());
        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }
}
