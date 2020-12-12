<?php

namespace Tests\Unit\Availability;

use App\Availability\Application\AvailabilityFacade;
use App\Availability\Application\GoCartAvailabilityConfiguration;
use App\Availability\Domain\ResourceAvailabilityException;
use App\Availability\Domain\ResourceTurnedOn;
use App\Availability\Domain\ResourceWithdrawn;
use App\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use App\Shared\InMemoryDomainEventDispatcher;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResource;
use function Tests\Fixtures\aWithdrawnResource;

class AvailabilityTest extends TestCase
{
    private AvailabilityFacade $availabilityFacade;
    private InMemoryResourceRepository $resourceRepository;
    private InMemoryDomainEventDispatcher $eventDispatcher;
    private GoCartAvailabilityConfiguration $availabilityConfiguration;

    public function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->eventDispatcher = new InMemoryDomainEventDispatcher();
        $this->availabilityConfiguration = new GoCartAvailabilityConfiguration();

        $this->availabilityFacade = $this->availabilityConfiguration
            ->availabilityFacade($this->resourceRepository, $this->eventDispatcher);
    }

    public function testCreateResource(): void
    {
        $resource = aResource();
        $this->availabilityFacade->createResource($resource->getId());

        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }

    public function testWithdrawResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // when
        $this->availabilityFacade->withdrawResource($resource->getId());

        // then
        self::assertEquals(
            new ResourceWithdrawn($this->eventDispatcher->first()->eventId(), $resource->getId()),
            $this->eventDispatcher->first()
        );
    }

    public function testWithdrawWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already withdrawn'));

        // when
        $this->availabilityFacade->withdrawResource($resource->getId());
    }

    public function testTurnOnWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // when
        $this->availabilityFacade->turnOnResource($resource->getId());

        // then
        self::assertEquals(
            new ResourceTurnedOn($this->eventDispatcher->first()->eventId(), $resource->getId()),
            $this->eventDispatcher->first()
        );
    }

    public function testTurnOnResource(): void
    {
        // given
        $resource = aResource();
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already turned on'));

        // when
        $this->availabilityFacade->turnOnResource($resource->getId());
    }
}
