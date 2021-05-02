<?php

declare(strict_types=1);

namespace App\Track;

use App\Shared\Common\DomainEventDispatcher;
use App\Shared\ResourceCreated;
use App\Shared\ResourceId;
use App\Track\Http\TrackRequest;
use Illuminate\Database\Eloquent\Collection;

class TrackInventory
{
    private DomainEventDispatcher $dispatcher;

    public function __construct(DomainEventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function create(TrackRequest $request): Track
    {
        $track = Track::create($request->validated());
        $trackCreated = ResourceCreated::newOne(
            ResourceId::of($track->uuid),
            $track->slots,
            $track->is_available
        );

        $this->dispatcher->dispatch($trackCreated);
        return $track;
    }

    /**
     * @return Collection
     *
     * @psalm-return Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function getList(): Collection
    {
        return Track::with('reservations')->get();
    }

    /**
     * @return Collection
     *
     * @psalm-return Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function reservations(ResourceId $resourceId): Collection
    {
        $id = $resourceId->id()->toString();
        return Track::where('uuid', $id)->first()->reservations()->get();
    }
}
