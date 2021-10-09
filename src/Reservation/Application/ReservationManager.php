<?php

declare(strict_types=1);


namespace Karting\Reservation\Application;

use Karting\Availability\Application\Command\ReserveResources;
use Karting\Availability\Domain\ReservationFailed;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\CancelReservation;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\Common\CommandBus;

class ReservationManager
{
    public function __construct(private ReservationRepository $repository, private CommandBus $bus)
    {
    }

    public function handleReservationCrated(ReservationCreated $reservationCreated): void
    {
        $resources = $reservationCreated->karts()->push($reservationCreated->track());
        $command = new ReserveResources(
            $resources,
            $reservationCreated->period(),
            $reservationCreated->reservationId()
        );

        $this->bus->dispatch($command);
    }

    public function handleResourceReserved(ResourceReserved $resourceReserved): void
    {
        $reservation = $this->repository->find($resourceReserved->reservationId());

        $reservation->updateProgress($resourceReserved->resourceId());
        $this->repository->save($reservation);

        if ($reservation->finished() && !$reservation->confirmed()) {
            $this->bus->dispatch(new ConfirmReservation($reservation->id()));
        }
    }

    public function handleReservationFailed(ReservationFailed $reservationFailed): void
    {
        $reservation = $this->repository->find($reservationFailed->reservationId());

        if (!$reservation->confirmed()) {
            $this->bus->dispatch(new CancelReservation($reservation->id()));
        }
    }

    public function subscribe($events): void
    {
        $events->listen(
            ReservationCreated::class,
            [ReservationManager::class, 'handleReservationCrated']
        );

        $events->listen(
            ResourceReserved::class,
            [ReservationManager::class, 'handleResourceReserved']
        );

        $events->listen(
            ReservationFailed::class,
            [ReservationManager::class, 'handleReservationFailed']
        );
    }
}
