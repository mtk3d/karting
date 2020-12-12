<?php

declare(strict_types=1);


namespace Tests\Feature\Availability;


use App\Availability\Application\AvailabilityFacade;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Domain\ResourceUnavailableException;
use App\Availability\Infrastructure\Repository\EloquentResourceRepository;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\Common\IlluminateDomainEventDispatcher;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Tests\Fixtures\aResourceReservedBetween;
use function Tests\Fixtures\aWithdrawnResource;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private AvailabilityFacade $availabilityFacade;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        app()->bind(ResourceRepository::class, EloquentResourceRepository::class);
        app()->bind(DomainEventDispatcher::class, IlluminateDomainEventDispatcher::class);
        $this->availabilityFacade = app()->make(AvailabilityFacade::class);
    }

    /**
     * @dataProvider succeedReservedDates
     */
    public function testReservation(string $alreadyFrom, string $alreadyTo, string $from, string $to): void
    {
        // given
        $resource = aResourceReservedBetween($alreadyFrom, $alreadyTo);
        $resource->save();


        $reservationPeriod = CarbonPeriod::create($from, $to);
        $this->availabilityFacade->reserve($resource->getId(), $reservationPeriod);

        // then
        $this->assertDatabaseHas('resource_items', [
            'id' => $resource->getId()->id(),
        ]);
        $this->assertDatabaseHas('reservations', [
            'resource_item_id' => $resource->getId()->id(),
        ]);
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
        $resource->save();

        // should
        $this->expectExceptionObject(new ResourceUnavailableException('ResourceItem unavailable'));

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
        $resource->push();

        // should
        $this->expectExceptionObject(new ResourceUnavailableException('Cannot reserve in this period'));

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
