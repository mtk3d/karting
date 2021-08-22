<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\CancelReservation;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\ReservationStatusChanged;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\Common\DomainEventBus;

class CancelReservationHandler
{
    public function __construct(private ReservationRepository $repository, private DomainEventBus $bus)
    {
    }

    public function handle(CancelReservation $cancelReservation)
    {
        $reservation = $this->repository->find($cancelReservation->reservationId());
        $reservation->cancel();

        $this->repository->save($reservation);

        $this->bus->dispatch(ReservationStatusChanged::newOne($reservation->id()));
    }
}
