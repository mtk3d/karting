<?php

namespace Tests\Unit\Availability;

use App\Availability\Application\AvailabilityService;
use App\Availability\Application\Command\CreateResource;
use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Application\Command\WithdrawResource;
use App\Availability\Application\CreateResourceHandler;
use App\Availability\Application\TurnOnResourceHandler;
use App\Availability\Application\WithdrawResourceHandler;
use App\Availability\Domain\ResourceAvailabilityException;
use App\Availability\Domain\ResourceTurnedOn;
use App\Availability\Domain\ResourceWithdrawn;
use App\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use App\Shared\Common\InMemoryDomainEventDispatcher;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResource;
use function Tests\Fixtures\aWithdrawnResource;

class AvailabilityTest extends TestCase
{
    private InMemoryResourceRepository $resourceRepository;
    private InMemoryDomainEventDispatcher $eventDispatcher;
    private CreateResourceHandler $createResourceHandler;
    private TurnOnResourceHandler $turnOnResourceHandler;
    private WithdrawResourceHandler $withdrawResourceHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->eventDispatcher = new InMemoryDomainEventDispatcher();

        $this->createResourceHandler = new CreateResourceHandler($this->resourceRepository, $this->eventDispatcher);
        $this->turnOnResourceHandler = new TurnOnResourceHandler($this->resourceRepository, $this->eventDispatcher);
        $this->withdrawResourceHandler = new WithdrawResourceHandler($this->resourceRepository, $this->eventDispatcher);
    }

    public function testCreateResource(): void
    {
        $resource = aResource();
        $this->createResourceHandler->handle(new CreateResource($resource->getId(), true));

        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testWithdrawResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // when
        $this->withdrawResourceHandler->handle(new WithdrawResource($resource->getId()));

        // then
        self::assertEquals(
            new ResourceWithdrawn($this->eventDispatcher->first()->eventId(), $resource->getId()),
            $this->eventDispatcher->first()
        );

        $resource = aWithdrawnResource($resource->getId());
        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testWithdrawWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already withdrawn'));

        // when
        $this->withdrawResourceHandler->handle(new WithdrawResource($resource->getId()));
    }

    public function testTurnOnWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // when
        $this->turnOnResourceHandler->handle(new TurnOnResource($resource->getId()));

        // then
        self::assertEquals(
            new ResourceTurnedOn($this->eventDispatcher->first()->eventId(), $resource->getId()),
            $this->eventDispatcher->first()
        );

        $resource = aResource($resource->getId());
        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testTurnOnResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already turned on'));

        // when
        $this->turnOnResourceHandler->handle(new TurnOnResource($resource->getId()));
    }
}
