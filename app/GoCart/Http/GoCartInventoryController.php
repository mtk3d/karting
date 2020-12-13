<?php

declare(strict_types=1);


namespace App\GoCart\Http;

use App\GoCart\GoCart;
use App\GoCart\GoCartInventory;
use App\GoCart\GoCartReservation;
use App\Shared\Http\Controller;
use App\Shared\ResourceId;
use Illuminate\Support\Collection;

class GoCartInventoryController extends Controller
{
    private GoCartInventory $goCartInventory;

    public function __construct(GoCartInventory $goCartInventory)
    {
        $this->goCartInventory = $goCartInventory;
    }

    public function create(GoCartRequest $request): GoCart
    {
        return $this->goCartInventory->create($request);
    }

    /**
     * @return Collection<int, GoCartReservation>
     */
    public function reservations(string $id): Collection
    {
        return $this->goCartInventory->reservations(ResourceId::of($id));
    }

    public function all(): Collection
    {
        return $this->goCartInventory->getList();
    }
}
