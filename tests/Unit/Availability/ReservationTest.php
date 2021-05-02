<?php

declare(strict_types=1);


namespace Tests\Unit\Availability;

use App\Availability\Application\Command\ReserveResource;
use App\Availability\Application\ReserveResourceHandler;
use App\Availability\Domain\ResourceReserved;
use App\Availability\Domain\ResourceUnavailableException;
use App\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use App\Shared\Common\InMemoryDomainEventDispatcher;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResourceNoSlotsBetween;
use function Tests\Fixtures\aResourceReservedBetween;
use function Tests\Fixtures\aResourceWithSlotBetween;
use function Tests\Fixtures\aWithdrawnResource;

class ReservationTest extends TestCase
{
    private InMemoryResourceRepository $resourceRepository;
    private InMemoryDomainEventDispatcher $eventDispatcher;
    private ReserveResourceHandler $reservationHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->eventDispatcher = new InMemoryDomainEventDispatcher();
        $this->reservationHandler = new ReserveResourceHandler($this->resourceRepository, $this->eventDispatcher);
    }

    /**
     * @dataProvider succeedReservedDates
     */
    public function testReservation(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $resource = aResourceReservedBetween(null, $alreadyFrom, $alreadyTo);
        $this->resourceRepository->save($resource);

        // when
        $id = $resource->getId()->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to);
        $this->reservationHandler->handle($reserveCommand);

        // then
        self::assertEquals(
            new ResourceReserved($this->eventDispatcher->first()->eventId(), $resource->getId(), $reserveCommand->period()),
            $this->eventDispatcher->first()
        );

        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
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
        self::expectExceptionObject(new ResourceUnavailableException('ResourceItem unavailable'));

        // when
        $id = $resource->getId()->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, '2020-12-06 15:30', '2020-12-06 16:30');
        $this->reservationHandler->handle($reserveCommand);
    }

    /**
     * @dataProvider failedReservedDates
     */
    public function testReserveAlreadyReservedResource(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $resource = aResourceReservedBetween(null, $alreadyFrom, $alreadyTo);
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

        // when
        $id = $resource->getId()->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to);
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
        $from = '2020-12-06 15:30';
        $to = '2020-12-06 16:30';
        $resource = aResourceNoSlotsBetween(null, $from, $to);
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

        // when
        $id = $resource->getId()->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to);
        $this->reservationHandler->handle($reserveCommand);
    }

    public function testReserveWithPlacesResource(): void
    {
        // given
        $from = '2020-12-06 15:30';
        $to = '2020-12-06 16:30';
        $resource = aResourceWithSlotBetween(null, $from, $to);
        $this->resourceRepository->save($resource);

        // when
        $id = $resource->getId()->id()->toString();
        $reserveCommand = ReserveResource::fromRaw($id, $from, $to);
        $this->reservationHandler->handle($reserveCommand);


        // then
        self::assertEquals(
            new ResourceReserved($this->eventDispatcher->first()->eventId(), $resource->getId(), $reserveCommand->period()),
            $this->eventDispatcher->first()
        );

        self::assertEquals($resource, $this->resourceRepository->find($resource->getId()));
    }
}
