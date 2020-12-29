<?php

declare(strict_types=1);

namespace App\GoCart;

use App\GoCart\Http\GoCartRequest;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\ResourceCreated;
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
        $resourceCreated = ResourceCreated::newOne(ResourceId::of($goCart->id), 1, $goCart->is_available);
        $this->dispatcher->dispatch($resourceCreated);
        return $goCart;
    }

    /**
     * @return Collection<int, GoCart>
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
