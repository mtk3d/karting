<?php

declare(strict_types=1);

namespace Karting\App\Http\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Karting\App\Http\Controller;
use Karting\App\Http\Controller\Request\StateRequest;
use Karting\App\Http\Controller\Request\TrackRequest;
use Karting\App\ReadModel\Kart\Kart;
use Karting\App\ReadModel\Reservation\Reservation;
use Karting\App\ReadModel\Track\Track;
use Karting\Availability\Application\Command\SetState;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;
use Karting\Track\Application\Command\CreateTrack;

class TrackController extends Controller
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function create(TrackRequest $request): Response
    {
        $this->bus->dispatch(new CreateTrack(
            new UUID($request->get('uuid')),
            $request->get('name'),
            $request->get('description'),
            $request->get('slots')
        ));

        $this->bus->dispatch(new SetState(
            ResourceId::of($request->get('uuid')),
            $request->get('enabled')
        ));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @return Collection<int, Kart>
     */
    public function all(): Collection
    {
        return Track::all();
    }

    public function state(string $id, StateRequest $request): Response
    {
        $this->bus->dispatch(new SetState(
            ResourceId::of($id),
            $request->get('enabled')
        ));

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function reservations(string $id): Collection
    {
        return Track::where('uuid', $id)->first()->reservations;
    }
}
