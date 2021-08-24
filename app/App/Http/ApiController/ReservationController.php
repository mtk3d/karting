<?php

declare(strict_types=1);

namespace Karting\App\Http\ApiController;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Karting\App\Http\ApiController\Request\ReservationRequest;
use Karting\App\ReadModel\Reservation\Reservation;
use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Shared\Common\CommandBus;

class ReservationController
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function create(ReservationRequest $request): Response
    {
        $this->bus->dispatch(CreateReservation::fromArray($request->validated()));

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @return Collection<Reservation>
     */
    public function all(): Collection
    {
        return Reservation::all();
    }
}
