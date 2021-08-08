<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Reservation extends Model
{
    protected $fillable = [
        'uuid',
        'go_carts_ids',
        'go_carts_reserved',
        'track_id',
        'from',
        'to'
    ];

    protected $attributes = [
        'accepted' => false,
        'go_carts_reserved' => []
    ];

    public static function of(ReservationId $reservationId, KartIds $kartIds, ResourceId $trackId, CarbonPeriod $period): Reservation
    {
        return new Reservation([
            'uuid' => $reservationId->id()->toString(),
            'go_carts_ids' => $kartIds->idsStrings()->toArray(),
            'go_carts_reserved' => $kartIds->reservedIdsStrings()->toArray(),
            'track_id' => $trackId->id()->toString(),
            'from' => $period->getStartDate()->toDateTimeString(),
            'to' => $period->getEndDate()->toDateTimeString(),
        ]);
    }

    public function accept(): void
    {
        $this->attributes['accepted'] = true;
    }

    public function id(): ReservationId
    {
        return ReservationId::of($this->attributes['uuid']);
    }

    public function goCartsIds(): KartIds
    {
        return KartIds::fromRaw($this->attributes['go_carts_ids'], $this->attributes['go_carts_reserved']);
    }

    /**
     * @throws \Exception
     */
    public function markGoCartAsReserved(ResourceId $kartId): void
    {
        $kartIds = KartIds::fromRaw($this->attributes['go_carts_ids'], $this->attributes['go_carts_reserved']);
        $kartIds->markReserved($kartId);

        $this->attributes['go_carts_reserved'] = $kartIds->reservedIdsStrings()->toArray();
    }

    public function trackId(): ResourceId
    {
        return ResourceId::of($this->attributes['track_id']);
    }

    public function period(): CarbonPeriod
    {
        return new CarbonPeriod($this->attributes['from'], $this->attributes['to']);
    }

    public function kartIds(): Collection
    {
        return (new Collection($this->attributes['go_carts_ids']))->map([ResourceId::class, 'of']);
    }
}
