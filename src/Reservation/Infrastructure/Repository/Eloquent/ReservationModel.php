<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Repository\Eloquent;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Karting\Reservation\Domain\Kart;
use Karting\Reservation\Domain\Status;
use Karting\Reservation\Domain\Track;
use Karting\Shared\CarbonPeriodCast;
use Karting\Shared\ReservationId;
use Karting\Shared\ReservationIdCast;

/**
 * @property ReservationId $uuid
 * @property Collection<int, Kart> $karts
 * @property Track $track
 * @property CarbonPeriod $period
 * @property Status $status
 */
class ReservationModel extends Model
{
    protected $table = 'reservations';

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
}
