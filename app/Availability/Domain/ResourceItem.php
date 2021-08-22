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

    public function reserve(CarbonPeriod $period, ReservationId $reservationId): Result
    {
        if (!$this->enabled()) {
            return Result::failure('ResourceItem is unavailable');
        }

        if (!$this->isAvailableIn($period)) {
            return Result::failure('Cannot reserve in this period');
        }

        $reservation = Reservation::of($period, $this->uuid, $reservationId);
        $this->reservations->add($reservation);

        $events = new Collection([
            ResourceReserved::newOne($this->uuid, $period, $reservationId)
        ]);

        return Result::success($events);
    }

    public function disable(): Result
    {
        $this->enabled = false;

        $events = new Collection([
            StateChanged::newOne($this->uuid, $this->enabled)
        ]);

        return Result::success($events);
    }

    public function enable(): Result
    {
        $this->enabled = true;

        $events = new Collection([
            StateChanged::newOne($this->uuid, $this->enabled)
        ]);

        return Result::success($events);
    }

    public function id(): ResourceId
    {
        return $this->uuid;
    }

    private function enabled(): bool
    {
        return $this->enabled;
    }

    private function isAvailableIn(CarbonPeriod $period): bool
    {
        $taken = $this->reservations
            ->filter(function (Reservation $reservation) use ($period): bool {
                return $reservation->overlaps($period);
            });

        if ($taken->isNotEmpty() && !$taken->first()->periodEqual($period)) {
            return false;
        }

        return $this->slots->hasMoreThan($taken->count());
    }
}
