<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\ResourceId;
use Illuminate\Support\Collection;

class KartIds
{
    private Collection $ids;
    private Collection $reservedIds;

    public function __construct(Collection $ids, ?Collection $reservedIds = null)
    {
        $this->ids = $ids;
        $this->reservedIds = $reservedIds ?? new Collection();
    }

    public static function fromRaw(array $kartIds, array $kartsReserved): KartIds
    {
        return new KartIds(new Collection($kartIds), new Collection($kartsReserved));
    }

    public function firstNonReserved(): ?ResourceId
    {
        return ResourceId::of($this->ids->diff($this->reservedIds)->first()) ?? null;
    }

    public function idsStrings(): Collection
    {
        return $this->ids->map(fn (ResourceId $id): string => $id->id()->toString());
    }

    public function reservedIdsStrings(): Collection
    {
        return $this->reservedIds;
    }

    public function markReserved(ResourceId $kartId): void
    {
        $id = $kartId->id()->toString();

        if (!$this->ids->contains($id) || $this->reservedIds->contains($id)) {
            throw new \Exception();
        }

        $this->reservedIds->push($id);
    }

    public function ids(): Collection
    {
        return $this->ids;
    }
}
