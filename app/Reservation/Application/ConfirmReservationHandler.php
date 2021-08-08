<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\ReservationRepository;

class ConfirmReservationHandler
{
    private ReservationRepository $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ConfirmReservation $confirmReservation)
    {
        $reservation = $this->repository->find($confirmReservation->reservationId());
        $reservation->confirm();

        $this->repository->save($reservation);
    }
}
