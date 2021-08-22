<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Reservation\Infrastructure\Repository\Eloquent\KartsCast;
use Karting\Reservation\Infrastructure\Repository\Eloquent\TrackCast;
use Karting\Shared\CarbonPeriodCast;
use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ReservationIdCast;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Reservation extends Model
{
    protected $fillable = [
        'uuid',
        'karts',
        'track',
        'period',
        'confirmed',
        'canceled'
    ];

    protected $attributes = [
        'karts' => [],
        'confirmed' => false
    ];

    protected $casts = [
        'uuid' => ReservationIdCast::class,
        'karts' => KartsCast::class,
        'track' => TrackCast::class,
        'period' => CarbonPeriodCast::class,
        'confirmed' => 'boolean',
    ];

    public static function of(ReservationId $reservationId, Collection $karts, Track $track, CarbonPeriod $period): Reservation
    {
        return new Reservation([
            'uuid' => $reservationId,
            'karts' => $karts,
            'track' => $track,
            'period' => $period,
        ]);
    }

    public function confirm(): Result
    {
        if ($this->confirmed) {
            throw new \Exception('ResourceReservation is already confirmed');
        }

        $this->confirmed = true;

        $events = new Collection([
            ReservationConfirmed::newOne($this->uuid)
        ]);

        return Result::success($events);
    }

    public function id(): ReservationId
    {
        return $this->uuid;
    }

    public function karts(): Collection
    {
        return $this->karts;
    }

    public function reserveTrack(): void
    {
        $this->track->reserve();
    }

    public function confirmed(): bool
    {
        return $this->confirmed;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }

    public function updateProgress(ResourceId $resourceId): void
    {
        if ($this->karts->contains(new Kart($resourceId, false))) {
            $this->karts = $this->karts->map(function (Kart $kart) use ($resourceId): Kart {
                if ($kart->resourceId()->isEqual($resourceId)) {
                    $kart->reserve();
                }

                return $kart;
            });
        }

        if ($this->track->resourceId()->isEqual($resourceId)) {
            $this->track->reserve();
        }
    }

    public function finished(): bool
    {
        return $this->track->reserved() && $this->kartsReserved();
    }

    private function kartsReserved(): bool
    {
        return $this->karts
            ->filter(fn (Kart $kart): bool => !$kart->reserved())
            ->isEmpty();
    }

    public function cancel()
    {
        $this->canceled = true;
    }
}
