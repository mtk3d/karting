<?php

declare(strict_types=1);

namespace Tests\Unit\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\Kart;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\ReservationManager;
use Karting\Reservation\Domain\Track;
use Karting\Reservation\Infrastructure\Repository\InMemoryReservationRepository;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\InMemoryCommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private InMemoryReservationRepository $reservationRepository;
    private CommandBus $bus;
    private ReservationManager $reservationManager;

    public function setUp(): void
    {
        $this->reservationRepository = new InMemoryReservationRepository();
        $this->bus = new InMemoryCommandBus();
        $this->reservationManager = new ReservationManager($this->reservationRepository, $this->bus);
    }

    public function testReservationManager(): void
    {
        $reservationId = new ReservationId(UUID::random());
        $firstKart = new Kart(new ResourceId(UUID::random()), false);
        $secondKart = new Kart(new ResourceId(UUID::random()), false);
        $karts = new Collection([$firstKart, $secondKart]);
        $track = new Track(new ResourceId(UUID::random()), false);
        $period = CarbonPeriod::create('2020-12-06 15:30', '2020-12-06 16:30');
        $reservation = Reservation::of($reservationId, $karts, $track, $period);
        $this->reservationRepository->save($reservation);

        $this->reservationManager->handleReservationCrated(ReservationCreated::newOne($reservationId, $karts->map(fn (Kart $k) => $k->resourceId()), $track->resourceId(), $period));
        $this->reservationManager->handleKartReserved(ResourceReserved::newOne($firstKart->resourceId(), $period, $reservationId));
        $this->reservationManager->handleKartReserved(ResourceReserved::newOne($secondKart->resourceId(), $period, $reservationId));
        $this->reservationManager->handleTrackReserved(ResourceReserved::newOne($track->resourceId(), $period, $reservationId));

        $dispatchedCommands = $this->bus->dispatchedCommands();

        // This part has a problem because of PHP bug
//        self::assertContainsEquals(new ReserveResource($kartId, $period), $dispatchedCommands);
        self::assertTrue($dispatchedCommands
                ->filter(fn ($item): bool => $item instanceof ConfirmReservation ? false : $firstKart->resourceId()->isEqual($item->id()))
                ->count() === 1);
        self::assertTrue($dispatchedCommands
                ->filter(fn ($item): bool => $item instanceof ConfirmReservation ? false : $secondKart->resourceId()->isEqual($item->id()))
                ->count() === 1);
        self::assertTrue($dispatchedCommands
                ->filter(fn ($item): bool => $item instanceof ConfirmReservation ? false : $track->resourceId()->isEqual($item->id()))
                ->count() === 1);

        self::assertContainsEquals(new ConfirmReservation($reservationId), $dispatchedCommands);
    }
}
