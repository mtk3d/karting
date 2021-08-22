<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\ReservationStatusChanged;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Reservation\Domain\Status;
use Karting\Shared\Common\DomainEventBus;

class ConfirmReservationHandler
{
    public function __construct(private ReservationRepository $repository, private DomainEventBus $bus)
    {
    }

    public function handle(ConfirmReservation $confirmReservation)
    {
        $reservation = $this->repository->find($confirmReservation->reservationId());
        $reservation->confirm();

        $this->repository->save($reservation);

        $this->bus->dispatch(ReservationStatusChanged::newOne($reservation->id(), Status::CONFIRMED()));
    }
}
