<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Reservation\Domain\KartIds;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationRepository;

class CreateReservationHandler
{
    private ReservationRepository $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateReservation $createReservation)
    {
        $reservation = Reservation::of(
            $createReservation->reservationId(),
            new KartIds($createReservation->kartIds()),
            $createReservation->trackId(),
            $createReservation->period()
        );

        $this->repository->save($reservation);
    }
}
