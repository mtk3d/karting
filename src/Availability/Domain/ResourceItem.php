<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Availability\Infrastructure\Repository\Eloquent\SlotsCast;
use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Karting\Shared\ResourceIdCast;

/**
 * @property ResourceId $uuid
 * @property Collection<int, Reservation> $reservations
 * @property bool $enabled
 * @property Slots $slots
 */
class ResourceItem extends Model
{
    protected $with = ['reservations'];

    protected $fillable = [
        'uuid',
        'slots',
        'enabled',
    ];

    protected $casts = [
        'uuid' => ResourceIdCast::class,
        'slots' => SlotsCast::class,
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
            'uuid' => $id,
            'slots' => $slots,
            'enabled' => $enabled
        ]);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'resource_item_id', 'uuid');
    }

    public function id(): ResourceId
    {
        return $this->uuid;
    }

    private function enabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return Collection<int, CarbonPeriod>
     */
    public function reservedPeriods(): Collection
    {
        return $this->reservations->map(fn (Reservation $r): CarbonPeriod => $r->period());
    }

    /**
     * @param Collection<int, Policy> $policies
     */
    public function reserve(CarbonPeriod $period, ReservationId $reservationId, Collection $policies): Result
    {
        if (!$this->enabled()) {
            return Result::failure(
                'ResourceItem is unavailable',
                ReservationFailed::newOne($this->uuid, $period, $reservationId)
            );
        }

        $satisfied = $policies->filter(function (Policy $policy) use ($period): bool {
            return !$policy->isSatisfiedBy($period, $this->reservedPeriods(), $this->slots);
        })->isEmpty();

        if (!$satisfied) {
            return Result::failure(
                'Cannot reserve in this period',
                ReservationFailed::newOne($this->uuid, $period, $reservationId)
            );
        }

        $reservation = Reservation::of($period, $this->uuid, $reservationId);
        $this->reservations->add($reservation);

        return Result::success(
            ResourceReserved::newOne($this->uuid, $period, $reservationId)
        );
    }

    public function disable(): Result
    {
        $this->enabled = false;

        return Result::success(
            StateChanged::newOne($this->uuid, $this->enabled)
        );
    }

    public function enable(): Result
    {
        $this->enabled = true;

        return Result::success(
            StateChanged::newOne($this->uuid, $this->enabled)
        );
    }

    public function setSlots(Slots $slots): Result
    {
        $this->slots = $slots;

        return Result::success(
            SlotsUpdated::newOne($this->uuid, $this->slots->quantity())
        );
    }
}
