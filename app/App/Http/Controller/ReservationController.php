<?php

declare(strict_types=1);

namespace Karting\App\Http\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Karting\App\Http\Controller\Request\ReservationRequest;
use Karting\App\ReadModel\Reservation\Reservation;
use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Shared\Common\CommandBus;

class ReservationController
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function create(ReservationRequest $request): Response
    {
        $this->bus->dispatch(CreateReservation::fromArray($request->validated()));

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function all(): Collection
    {
        return Reservation::all();
    }
}
