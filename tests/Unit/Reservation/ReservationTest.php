<?php

declare(strict_types=1);

namespace Tests\Unit\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Karting\Availability\Application\Command\ReserveResources;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Application\ReservationManager;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\ReservationFactory;
use Karting\Reservation\Domain\Status;
use Karting\Reservation\Infrastructure\Factory\StdClassReservationFactory;
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
    private ReservationFactory $reservationFactory;

    public function setUp(): void
    {
        $this->reservationRepository = new InMemoryReservationRepository();
        $this->bus = new InMemoryCommandBus();
        $this->reservationManager = new ReservationManager($this->reservationRepository, $this->bus);
        $this->reservationFactory = new StdClassReservationFactory();
    }

    public function testReservationManager(): void
    {
        $reservationId = ReservationId::newOne();
        $firstKartId = ResourceId::newOne();
        $secondKartId = ResourceId::newOne();
        $kartsIds = collect([$firstKartId, $secondKartId]);
        $trackId = ResourceId::newOne();
        $period = CarbonPeriod::create('2020-12-06 15:30', '2020-12-06 16:30');
        $reservation = $this->reservationFactory->from($reservationId, $kartsIds, $trackId, $period);
        $this->reservationRepository->save($reservation);

        $this->reservationManager->handleReservationCrated(ReservationCreated::newOne($reservationId, $kartsIds, $trackId, $period, Status::IN_PROGRESS()));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($firstKartId, $period, $reservationId));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($secondKartId, $period, $reservationId));
        $this->reservationManager->handleResourceReserved(ResourceReserved::newOne($trackId, $period, $reservationId));

        $dispatchedCommands = $this->bus->dispatchedCommands();

        /** @var ReserveResources $reservationCommand */
        $reservationCommand = $dispatchedCommands->whereInstanceOf(ReserveResources::class)->first();

        self::assertTrue($reservationCommand->ids()->contains($firstKartId));
        self::assertTrue($reservationCommand->ids()->contains($secondKartId));
        self::assertTrue($reservationCommand->ids()->contains($trackId));

        self::assertContainsEquals(new ConfirmReservation($reservationId), $dispatchedCommands);
    }
}
