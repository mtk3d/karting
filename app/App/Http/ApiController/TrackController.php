<?php

declare(strict_types=1);

namespace Karting\App\Http\ApiController;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Karting\App\Http\ApiController\Request\StateRequest;
use Karting\App\Http\ApiController\Request\TrackRequest;
use Karting\App\Http\Controller;
use Karting\App\ReadModel\Track\Track;
use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Domain\Slots;
use Karting\Pricing\Application\Command\SetPrice;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;
use Karting\Track\Application\Command\CreateTrack;
use Money\Currency;
use Money\Money;

class TrackController extends Controller
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function create(TrackRequest $request): Response
    {
        $this->bus->dispatch(new CreateTrack(
            new UUID($request->get('uuid')),
            $request->get('name'),
            $request->get('description'),
            $request->get('slots')
        ));

        $this->bus->dispatch(new CreateResource(
            ResourceId::of($request->get('uuid')),
            new Slots($request->get('slots')),
            $request->get('enabled')
        ));

        $this->bus->dispatch(SetPrice::of(
            new UUID($request->get('uuid')),
            new Money($request->get('price'), new Currency('USD'))
        ));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @return Collection<Track>
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
     * @return Collection<Track>
     */
    public function reservations(string $id): Collection
    {
        return Track::where('uuid', $id)->firstOrFail()->reservations;
    }
}
