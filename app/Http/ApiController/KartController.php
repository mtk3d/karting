<?php

declare(strict_types=1);

namespace App\Http\ApiController;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use App\Http\ApiController\Request\KartRequest;
use App\Http\ApiController\Request\StateRequest;
use App\Http\Controller;
use App\ReadModel\Kart\Kart;
use App\ReadModel\ResourceReservation\ResourceReservation;
use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Domain\Slots;
use Karting\Kart\Application\Command\CreateKart;
use Karting\Pricing\Application\Command\SetPrice;
use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;
use Money\Currency;
use Money\Money;

class KartController extends Controller
{
    public function __construct(private CommandBus $bus)
    {
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

        $this->bus->dispatch(SetPrice::of(
            new UUID($request->get('uuid')),
            new Money($request->get('price'), new Currency('USD'))
        ));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @return Collection<Kart>
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
     * @return Collection<ResourceReservation>
     */
    public function reservations(string $id): Collection
    {
        return Kart::where('uuid', $id)->firstOrFail()->reservations;
    }
}
