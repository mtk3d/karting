<?php

declare(strict_types=1);

namespace Karting\App\Http\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Karting\App\Http\Controller;
use Karting\App\Http\Controller\Request\KartRequest;
use Karting\App\Http\Controller\Request\StateRequest;
use Karting\App\ReadModel\Kart\Kart;
use Karting\App\ReadModel\ResourceReservation\ResourceReservation;
use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Domain\Slots;
use Karting\Kart\Application\Command\CreateKart;
use Karting\Pricing\Application\Command\SetPrice;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;

class KartController extends Controller
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function create(KartRequest $request): Response
    {
        $this->bus->dispatch(new CreateKart(
            new UUID($request->get('uuid')),
            $request->get('name'),
            $request->get('description')
        ));

        $this->bus->dispatch(new CreateResource(
            ResourceId::of($request->get('uuid')),
            new Slots(1),
            $request->get('enabled')
        ));

        $this->bus->dispatch(new SetPrice(
            new UUID($request->get('uuid')),
            $request->get('price')
        ));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @return Collection<int, Kart>
     */
    public function all(): Collection
    {
        return Kart::all();
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
     * @return Collection<int, ResourceReservation>
     */
    public function reservations(string $id): Collection
    {
        return Kart::where('uuid', $id)->first()->reservations;
    }
}
