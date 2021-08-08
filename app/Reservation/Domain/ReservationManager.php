<?php

declare(strict_types=1);


namespace Karting\Reservation\Domain;

use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\AcceptReservation;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\ResourceId;

class ReservationManager
{
    private ReservationRepository $repository;
    private CommandBus $bus;

    public function __construct(ReservationRepository $repository, CommandBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function handleReservationCrated(ReservationCreated $reservationCreated): void
    {
        $reservation = $this->repository->find($reservationCreated->reservationId());

        $this->bus->dispatch(
            new ReserveResource($reservation->goCartsIds()->firstNonReserved(), $reservation->period(), $reservationCreated->reservationId())
        );
    }

    public function handleKartReserved(ResourceReserved $resourceReserved): void
    {
        $resourceId = $resourceReserved->resourceId();
        $reservation = $this->repository->findByGoCartId($resourceId);
        $reservation->markGoCartAsReserved($resourceId);
        $notReservedGoCarts = $reservation->goCartsIds()->ids();
        if ($notReservedGoCarts->isNotEmpty()) {
            $this->bus->dispatch(
                new ReserveResource(ResourceId::of($notReservedGoCarts->first()), $reservation->period(), $reservation->id())
            );
        } else {
            $this->bus->dispatch(
                new ReserveResource($reservation->trackId(), $reservation->period(), $reservation->id())
            );
        }
    }

    public function handleTrackReserved(ResourceReserved $resourceReserved): void
    {
        $reservation = $this->repository->findByTrackId($resourceReserved->resourceId());
        $this->bus->dispatch(
            new AcceptReservation($reservation->id())
        );
    }
}
