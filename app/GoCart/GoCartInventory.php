<?php

declare(strict_types=1);

namespace App\GoCart;

use App\Shared\ResourceId;
use Illuminate\Database\Eloquent\Collection;

class GoCartInventory
{
    public function create(GoCartRequest $request): void
    {
        $goCart = GoCart::create($request->validated());
        event(GoCartCreated::newOne(new ResourceId($goCart->id)));
    }

    /**
     * @return Collection<GoCart>
     */
    public function getList(): Collection
    {
        return GoCart::with('reservations')->all();
    }
}
