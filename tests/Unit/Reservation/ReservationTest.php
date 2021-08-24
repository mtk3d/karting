<?php

declare(strict_types=1);

namespace Tests\Unit\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Karting\Availability\Application\Command\ReserveResources;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Application\ReservationManager;
use Karting\Reservation\Domain\Kart;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\Status;
use Karting\Reservation\Domain\Track;
use Karting\Reservation\Infrastructure\Repository\InMemoryReservationRepository;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\InMemoryCommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
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
        $karts = collect([$firstKart, $secondKart]);
        $track = new Track(new ResourceId(UUID::random()), false);
        $period = CarbonPeriod::create('2020-12-06 15:30', '2020-12-06 16:30');
        $reservation = Reservation::of($reservationId, $karts, $track, $period);
        $this->reservationRepository->save($reservation);

        $this->reservationManager->handleReservationCrated(ReservationCreated::newOne($reservationId, $karts->map(fn (Kart $k) => $k->resourceId()), $track->resourceId(), $period, Status::IN_PROGRESS()));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($firstKart->resourceId(), $period, $reservationId));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($secondKart->resourceId(), $period, $reservationId));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($track->resourceId(), $period, $reservationId));

        $dispatchedCommands = $this->bus->dispatchedCommands();

        /** @var ReserveResources $reservationCommand */
        $reservationCommand = $dispatchedCommands->whereInstanceOf(ReserveResources::class)->first();

        self::assertTrue($reservationCommand->ids()->contains($firstKart->resourceId()));
        self::assertTrue($reservationCommand->ids()->contains($secondKart->resourceId()));
        self::assertTrue($reservationCommand->ids()->contains($track->resourceId()));

        self::assertContainsEquals(new ConfirmReservation($reservationId), $dispatchedCommands);
    }
}
