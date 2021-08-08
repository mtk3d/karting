<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\AcceptReservation;
use Karting\Reservation\Domain\ReservationRepository;

class AcceptReservationHandler
{
    private ReservationRepository $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AcceptReservation $acceptReservation)
    {
        $reservation = $this->repository->find($acceptReservation->reservationId());
        $reservation->accept();

        $this->repository->save($reservation);
    }
}
