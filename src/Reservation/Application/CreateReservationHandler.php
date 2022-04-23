<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Reservation\Domain\Kart;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\ReservationFactory;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Reservation\Domain\Track;
use Karting\Shared\Common\DomainEventBus;
use Karting\Shared\ResourceId;

class CreateReservationHandler
{
    public function __construct(
        private ReservationRepository $repository,
        private ReservationFactory $reservationFactory,
        private DomainEventBus $bus
    ) {}

    public function handle(CreateReservation $createReservation): void
    {
        $reservation = $this->reservationFactory->from(
            $createReservation->reservationId(),
            $createReservation->kartIds(),
            $createReservation->trackId(),
            $createReservation->period()
        );

        $this->repository->save($reservation);

        $reservationCreated = ReservationCreated::newOne(
            $createReservation->reservationId(),
            $createReservation->kartIds(),
            $createReservation->trackId(),
            $createReservation->period(),
            $reservation->status()
        );

        $this->bus->dispatch($reservationCreated);
    }
}
