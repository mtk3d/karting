<?php

declare(strict_types=1);


namespace Tests\Unit\Availability;

use Illuminate\Support\Collection;
use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Application\Command\ReserveResources;
use Karting\Availability\Application\ReserveResourceHandler;
use Karting\Availability\Application\ReserveResourcesHandler;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Availability\Domain\ResourceUnavailableException;
use Karting\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use Karting\Shared\Common\InMemoryDomainEventBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResource;
use function Tests\Fixtures\aResourceNoSlotsBetween;
use function Tests\Fixtures\aResourceReservedBetween;
use function Tests\Fixtures\aResourceWithSlotBetween;
use function Tests\Fixtures\aWithdrawnResource;

class ReservationTest extends TestCase
{
    private InMemoryResourceRepository $resourceRepository;
    private InMemoryDomainEventBus $eventDispatcher;
    private ReserveResourceHandler $reservationHandler;
    private ReserveResourcesHandler $multiReservationHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->eventDispatcher = new InMemoryDomainEventBus();
        $this->reservationHandler = new ReserveResourceHandler($this->resourceRepository, $this->eventDispatcher);
        $this->multiReservationHandler = new ReserveResourcesHandler($this->resourceRepository, $this->eventDispatcher);
    }

    /**
     * @dataProvider succeedReservedDates
     */
    public function testReservation(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $reservationId = ReservationId::newOne();
        $resource = aResourceReservedBetween(null, $alreadyFrom, $alreadyTo, $reservationId);
        $this->resourceRepository->save($resource);

        // when
        $id = $resource->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to, $reservationId->id()->toString());
        $this->reservationHandler->handle($reserveCommand);

        // then
        self::assertEquals(
            new ResourceReserved($this->eventDispatcher->first()->eventId(), $resource->id(), $reserveCommand->period(), $reservationId),
            $this->eventDispatcher->first()
        );

        self::assertEquals($resource, $this->resourceRepository->find($resource->id()));
    }

    public function succeedReservedDates(): array
    {
        return [
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-07 15:00', '2020-12-07 16:00'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 16:00', '2020-12-06 17:00'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 14:00', '2020-12-06 15:00'],
        ];
    }

    public function testReserveWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('PricedItem unavailable'));

        // when
        $reservationId = UUID::random()->toString();
        $id = $resource->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, '2020-12-06 15:30', '2020-12-06 16:30', $reservationId);
        $this->reservationHandler->handle($reserveCommand);
    }

    /**
     * @dataProvider failedReservedDates
     */
    public function testReserveAlreadyReservedResource(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $reservationId = UUID::random()->toString();
        $resource = aResourceReservedBetween(null, $alreadyFrom, $alreadyTo, ReservationId::of($reservationId));
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

        // when
        $id = $resource->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to, $reservationId);
        $this->reservationHandler->handle($reserveCommand);
    }

    public function failedReservedDates(): array
    {
        return [
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 15:30', '2020-12-06 16:30'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 14:00', '2020-12-06 15:01'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 15:59', '2020-12-06 16:59'],
        ];
    }

    public function testReserveNoPlacesResource(): void
    {
        // given
        $reservationId = UUID::random()->toString();
        $from = '2020-12-06 15:30';
        $to = '2020-12-06 16:30';
        $resource = aResourceNoSlotsBetween(null, $from, $to, ReservationId::of($reservationId));
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

        // when
        $id = $resource->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to, $reservationId);
        $this->reservationHandler->handle($reserveCommand);
    }

    public function testReserveWithPlacesResource(): void
    {
        // given
        $reservationId = ReservationId::newOne();
        $from = '2020-12-06 15:30';
        $to = '2020-12-06 16:30';
        $resource = aResourceWithSlotBetween(null, $from, $to, $reservationId);
        $this->resourceRepository->save($resource);

        // when
        $id = $resource->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to, $reservationId->id()->toString());
        $this->reservationHandler->handle($reserveCommand);

        // then
        self::assertEquals(
            new ResourceReserved($this->eventDispatcher->first()->eventId(), $resource->id(), $reserveCommand->period(), $reservationId),
            $this->eventDispatcher->first()
        );

        self::assertEquals($resource, $this->resourceRepository->find($resource->id()));
    }

    public function testMultipleResources(): void
    {
        // given
        $reservationId = ReservationId::newOne();
        $firstResource = aResource();
        $secondResource = aResource();
        $this->resourceRepository->save($firstResource);
        $this->resourceRepository->save($secondResource);

        // when
        $firstId = $firstResource->id()->toString();
        $secondId = $secondResource->id()->toString();
        $resources = [$firstId, $secondId];
        $reserveCommand = ReserveResources::fromRaw($resources, '2020-12-06 15:00', '2020-12-06 16:00', $reservationId->id()->toString());
        $this->multiReservationHandler->handle($reserveCommand);

        // then
        $eventsIterator = $this->eventDispatcher->events()->getIterator();
        self::assertEquals(
            new ResourceReserved($eventsIterator->current()->eventId(), $firstResource->id(), $reserveCommand->period(), $reservationId),
            $eventsIterator->current()
        );

        $eventsIterator->next();

        self::assertEquals(
            new ResourceReserved($eventsIterator->current()->eventId(), $secondResource->id(), $reserveCommand->period(), $reservationId),
            $eventsIterator->current()
        );
    }
}
