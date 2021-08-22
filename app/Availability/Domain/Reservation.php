<?php

declare(strict_types=1);


namespace Karting\Availability\Domain;

use Karting\Shared\CarbonPeriodCast;
use Karting\Shared\Common\UUID;
use Karting\Shared\Common\UUIDCast;
use Karting\Shared\ReservationId;
use Karting\Shared\ReservationIdRelationCast;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Karting\Shared\ResourceIdRelationCast;

/**
 * @property UUID $uuid
 * @property CarbonPeriod $period
 */
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
        'resource_item_id' => ResourceIdRelationCast::class,
        'reservation_id' => ReservationIdRelationCast::class,
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

    public function overlaps(CarbonPeriod $period): bool
    {
        return $this->period->overlaps($period);
    }

    public function periodEqual(CarbonPeriod $period): bool
    {
        return $this->period->equalTo($period);
    }
}
