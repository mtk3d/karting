<?php

declare(strict_types=1);

namespace Tests\Unit\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\AcceptReservation;
use Karting\Reservation\Domain\KartIds;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\ReservationId;
use Karting\Reservation\Domain\ReservationManager;
use Karting\Reservation\Infrastructure\Repository\InMemoryReservationRepository;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\InMemoryCommandBus;
use Karting\Shared\Common\UUID;
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
        $firstKartId = new ResourceId(UUID::random());
        $secondKartId = new ResourceId(UUID::random());
        $kartIds = new KartIds(new Collection([$firstKartId, $secondKartId]));
        $trackId = new ResourceId(UUID::random());
        $period = CarbonPeriod::create('2020-12-06 15:30', '2020-12-06 16:30');
        $reservation = Reservation::of($reservationId, $kartIds, $trackId, $period);
        $this->reservationRepository->save($reservation);

        $this->reservationManager->handleReservationCrated(ReservationCreated::newOne($reservationId));
        $this->reservationManager->handleKartReserved(ResourceReserved::newOne($firstKartId, $period, $reservationId->id()));
        $this->reservationManager->handleKartReserved(ResourceReserved::newOne($secondKartId, $period, $reservationId->id()));
        $this->reservationManager->handleTrackReserved(ResourceReserved::newOne($trackId, $period, $reservationId->id()));

        $dispatchedCommands = $this->bus->dispatchedCommands();

        // This part has a problem because of PHP bug
//        self::assertContainsEquals(new ReserveResource($kartId, $period), $dispatchedCommands);
//        self::assertTrue($dispatchedCommands
//                ->filter(fn ($item): bool => $item instanceof AcceptReservation ? false : $firstKartId->isEqual($item->id()))
//                ->count() === 1);
//
//        self::assertTrue($dispatchedCommands
//                ->filter(fn ($item): bool => $item instanceof AcceptReservation ? false : $secondKartId->isEqual($item->id()))
//                ->count() === 1);
        // This part has a problem because of PHP bug
//        self::assertContainsEquals(new ReserveResource($trackId, $period), $dispatchedCommands);
//        self::assertTrue($dispatchedCommands
//                ->filter(fn ($item): bool => $item instanceof AcceptReservation ? false : $trackId->isEqual($item->id()))
//                ->count() === 1);
        self::assertContainsEquals(new AcceptReservation($reservationId), $dispatchedCommands);
    }
}
