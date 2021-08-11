<?php

declare(strict_types=1);


namespace Karting\Reservation\Application;

use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Domain\Kart;
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
        $reservation = $this->repository->find($reservationCreated->reservationId());
        $reservation->karts()
            ->map(fn (Kart $kart): ReserveResource => new ReserveResource($kart->resourceId(), $reservation->period(), $reservation->id()))
            ->push(new ReserveResource($reservationCreated->track(), $reservationCreated->period(), $reservationCreated->reservationId()))
            ->each([$this->bus, 'dispatch']);
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
    }
}
