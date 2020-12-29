<?php

declare(strict_types=1);


namespace App\Track\Http;


use App\Shared\Http\Controller;
use App\Shared\ResourceId;
use App\Track\Track;
use App\Track\TrackInventory;
use App\Track\TrackReservation;
use Illuminate\Support\Collection;

class TrackInventoryController extends Controller
{
    private TrackInventory $trackInventory;

    public function __construct(TrackInventory $trackInventory)
    {
        $this->trackInventory = $trackInventory;
    }

    public function create(TrackRequest $request): Track
    {
        return $this->trackInventory->create($request);
    }

    /**
     * @return Collection<int, TrackReservation>
     */
    public function reservations(string $id): Collection
    {
        return $this->trackInventory->reservations(ResourceId::of($id));
    }

    public function all(): Collection
    {
        return $this->trackInventory->getList();
    }
}
