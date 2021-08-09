<?php

declare(strict_types=1);

namespace Karting\Reservation\Application;

use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\ReservationConfirmed;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\Common\DomainEventBus;

class ConfirmReservationHandler
{
    private ReservationRepository $repository;
    private DomainEventBus $bus;

    public function __construct(ReservationRepository $repository, DomainEventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function handle(ConfirmReservation $confirmReservation)
    {
        $reservation = $this->repository->find($confirmReservation->reservationId());
        $reservation->confirm();

        $this->repository->save($reservation);

        $this->bus->dispatch(ReservationConfirmed::newOne($reservation->id()));
    }
}
