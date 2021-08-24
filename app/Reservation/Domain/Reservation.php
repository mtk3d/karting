<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Exception;
use Karting\Reservation\Infrastructure\Repository\Eloquent\KartsCast;
use Karting\Reservation\Infrastructure\Repository\Eloquent\StatusCast;
use Karting\Reservation\Infrastructure\Repository\Eloquent\TrackCast;
use Karting\Shared\CarbonPeriodCast;
use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ReservationIdCast;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property ReservationId $uuid
 * @property Collection<int, Kart> $karts
 * @property Track $track
 * @property CarbonPeriod $period
 * @property Status $status
 */
class Reservation extends Model
{
    protected $fillable = [
        'uuid',
        'karts',
        'track',
        'period',
        'status'
    ];

    protected $casts = [
        'uuid' => ReservationIdCast::class,
        'karts' => KartsCast::class,
        'track' => TrackCast::class,
        'period' => CarbonPeriodCast::class,
        'status' => StatusCast::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function of(ReservationId $reservationId, Collection $karts, Track $track, CarbonPeriod $period): Reservation
    {
        return new Reservation([
            'uuid' => $reservationId,
            'karts' => $karts,
            'track' => $track,
            'period' => $period,
            'status' => Status::IN_PROGRESS()
        ]);
    }

    /**
     * @throws Exception
     */
    public function confirm(): Result
    {
        if ($this->status->equals(Status::CANCELED())) {
            throw new Exception('ResourceReservation is canceled');
        }

        if ($this->status->equals(Status::CONFIRMED())) {
            throw new Exception('ResourceReservation is already confirmed');
        }

        $this->status = Status::CONFIRMED();

        return Result::success(collect(
            ReservationStatusChanged::newOne($this->uuid, $this->status)
        ));
    }

    public function cancel()
    {
        $this->status = Status::CANCELED();
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
        return $this->status->equals(Status::CONFIRMED());
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

    public function status(): Status
    {
        return $this->status;
    }
}
