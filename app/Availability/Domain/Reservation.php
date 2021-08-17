<?php

declare(strict_types=1);


namespace Karting\Availability\Domain;

use Karting\Shared\CarbonPeriodCast;
use Karting\Shared\Common\UUID;
use Karting\Shared\Common\UUIDCast;
use Karting\Shared\ReservationId;
use Karting\Shared\ReservationIdCast;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Karting\Shared\ResourceIdCast;

class Reservation extends Model
{
    protected $table = 'resource_reservations';

    protected $fillable = [
        'uuid',
        'period',
        'resource_item_id',
        'reservation_id',
    ];

    protected $casts = [
        'uuid' => UUIDCast::class,
        'period' => CarbonPeriodCast::class,
        'resource_item_id' => ResourceIdCast::class,
        'reservation_id' => ReservationIdCast::class,
    ];

    public static function of(CarbonPeriod $period, ResourceId $resourceId, ReservationId $reservationId): Reservation
    {
        return new Reservation([
            'uuid' => UUID::random(),
            'period' => $period,
            'resource_item_id' => $resourceId,
            'reservation_id' => $reservationId,
        ]);
    }

    public function id(): UUID
    {
        return $this->uuid;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }
}
