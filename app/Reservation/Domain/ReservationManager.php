<?php

declare(strict_types=1);


namespace Karting\Reservation\Domain;

use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Domain\ResourceReserved;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Shared\Common\CommandBus;

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
        $res = $this->repository->find($reservationCreated->reservationId());
        $res->karts()
            ->map(fn (Kart $kart): ReserveResource => new ReserveResource($kart->resourceId(), $res->period(), $res->id()))
            ->each([$this->bus, 'dispatch']);
    }

    public function handleKartReserved(ResourceReserved $resourceReserved): void
    {
        $resourceId = $resourceReserved->resourceId();
        $reservation = $this->repository->find($resourceReserved->reservationId());
        $reservation->reserveKart($resourceId);


        if ($reservation->kartsReserved()) {
            $this->bus->dispatch(
                new ReserveResource($reservation->trackId(), $reservation->period(), $reservation->id())
            );
        }
    }

    public function handleTrackReserved(ResourceReserved $resourceReserved): void
    {
        $reservation = $this->repository->find($resourceReserved->reservationId());
        $this->bus->dispatch(
            new ConfirmReservation($reservation->id())
        );
    }
}
