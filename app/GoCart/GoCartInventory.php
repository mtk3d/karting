<?php

declare(strict_types=1);

namespace App\GoCart;

use App\GoCart\Http\GoCartRequest;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\ResourceId;
use Illuminate\Database\Eloquent\Collection;

class GoCartInventory
{
    private DomainEventDispatcher $dispatcher;

    public function __construct(DomainEventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function create(GoCartRequest $request): GoCart
    {
        $goCart = GoCart::create($request->validated());
        $this->dispatcher->dispatch(GoCartCreated::newOne(ResourceId::of($goCart->id), $goCart->is_available));
        return $goCart;
    }

    /**
     * @return Collection<GoCart>
     */
    public function getList(): Collection
    {
        return GoCart::with('reservations')->get();
    }

    /**
     * @return Collection<int, GoCartReservation>
     */
    public function reservations(ResourceId $resourceId): Collection
    {
        $id = (string)$resourceId->id();
        return GoCartReservation::where('go_cart_id', $id)
            ->get();
    }
}
