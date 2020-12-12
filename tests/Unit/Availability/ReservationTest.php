<?php

declare(strict_types=1);


namespace Tests\Unit\Availability;


use App\Availability\Application\AvailabilityFacade;
use App\Availability\Application\GoCartAvailabilityConfiguration;
use App\Availability\Domain\ResourceReserved;
use App\Availability\Domain\ResourceUnavailableException;
use App\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use App\Shared\Common\InMemoryDomainEventDispatcher;
use Carbon\CarbonPeriod;
use PHPUnit\Framework\TestCase;
use function Tests\Fixtures\aResourceReservedBetween;
use function Tests\Fixtures\aWithdrawnResource;

class ReservationTest extends TestCase
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

    /**
     * @dataProvider succeedReservedDates
     */
    public function testReservation(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $resource = aResourceReservedBetween($alreadyFrom, $alreadyTo);
        $this->resourceRepository->save($resource);

        // when
        $reservationPeriod = CarbonPeriod::create($from, $to);
        $this->availabilityFacade->reserve($resource->getId(), $reservationPeriod);

        // then
        self::assertEquals(
            new ResourceReserved($this->eventDispatcher->first()->eventId(), $resource->getId(), $reservationPeriod),
            $this->eventDispatcher->first());
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
        $reservationPeriod = CarbonPeriod::create('2020-12-06 15:30', '2020-12-06 16:30');
        $this->availabilityFacade->reserve($resource->getId(), $reservationPeriod);
    }

    /**
     * @dataProvider failedReservedDates
     */
    public function testReserveAlreadyReservedResource(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $resource = aResourceReservedBetween($alreadyFrom, $alreadyTo);
        $this->resourceRepository->save($resource);

        // should
        self::expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

        // when
        $reservationPeriod = CarbonPeriod::create($from, $to);
        $this->availabilityFacade->reserve($resource->getId(), $reservationPeriod);
    }

    public function failedReservedDates(): array
    {
        return [
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 15:30', '2020-12-06 16:30'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 14:00', '2020-12-06 15:01'],
            ['2020-12-06 15:00', '2020-12-06 16:00', '2020-12-06 15:59', '2020-12-06 16:59'],
        ];
    }
}
