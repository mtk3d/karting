<?php

declare(strict_types=1);

namespace Karting\App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Karting\App\Http\Controller\Request\ReservationRequest;
use Karting\App\ReadModel\Kart\Kart;
use Karting\App\ReadModel\Reservation\Reservation;
use Karting\App\ReadModel\Track\Track;
use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Shared\Common\CommandBus;
use Ramsey\Uuid\Uuid;

class ReservationController
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function index(): View
    {
        return view('reservation.index', ['reservations' => Reservation::all()]);
    }

    public function create(): View
    {
        return view('reservation.create', ['karts' => Kart::all(), 'tracks' => Track::all(), 'uuid' => Uuid::uuid4()]);
    }

    public function reserve(ReservationRequest $request): RedirectResponse
    {
        $this->bus->dispatch(CreateReservation::fromArray($request->validated()));

        return redirect('/reservation');
    }
}
