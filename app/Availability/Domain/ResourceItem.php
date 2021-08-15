<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class ResourceItem extends Model
{
    protected $with = ['reservations'];

    protected $fillable = [
        'uuid',
        'slots',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $attributes = [
        'enabled' => true,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->relations['reservations'] = new EloquentCollection();
    }

    public static function of(ResourceId $id, Slots $slots, bool $enabled = true): ResourceItem
    {
        return new ResourceItem([
            'uuid' => $id->id(),
            'slots' => $slots->quantity(),
            'enabled' => $enabled
        ]);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'resource_item_id', 'uuid');
    }

    public function reserve(CarbonPeriod $period, ReservationId $reservationId): Result
    {
        if (!$this->enabled()) {
            return Result::failure('PricedItem unavailable');
        }

        if (!$this->isAvailableIn($period)) {
            return Result::failure('Cannot reserve in this period');
        }

        $reservation = Reservation::of($period, $this->id(), $reservationId);
        $this->reservations->add($reservation);

        $events = new Collection([
            ResourceReserved::newOne($this->id(), $period, $reservationId)
        ]);


        return Result::success($events);
    }

    public function disable(): Result
    {
        $this->enabled = false;

        $events = new Collection([
            StateChanged::newOne($this->id(), $this->enabled)
        ]);

        return Result::success($events);
    }

    public function enable(): Result
    {
        $this->enabled = true;

        $events = new Collection([
            StateChanged::newOne($this->id(), $this->enabled)
        ]);

        return Result::success($events);
    }

    public function id(): ResourceId
    {
        return ResourceId::of($this->uuid);
    }

    private function enabled(): bool
    {
        return $this->enabled;
    }

    private function isAvailableIn(CarbonPeriod $period): bool
    {
        $slots = Slots::of($this->slots);
        $taken = $this->reservations
            ->filter(function (Reservation $reservation) use ($period): bool {
                return $reservation->period()->overlaps($period);
            })->count();

        return $slots->hasMoreThan($taken);
    }

    public function setSlots(int $slots): Result
    {
        $this->slots = $slots;

        $events = new Collection([
            SlotsUpdated::newOne($this->id(), (int)$this->slots)
        ]);

        return Result::success($events);
    }
}
