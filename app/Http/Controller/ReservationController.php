<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controller\Request\ReservationRequest;
use App\ReadModel\Reservation\Reservation;
use Karting\Kart\Kart;
use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Reservation\Domain\ReservationConfirmationException;
use Karting\Shared\Common\CommandBus;
use Karting\Track\Track;
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
