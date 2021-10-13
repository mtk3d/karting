<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Karting\Availability\Domain\Policy;
use Karting\Availability\Domain\Slots;
use Karting\Availability\Infrastructure\Repository\Eloquent\RecurrenceCast;
use Karting\Availability\Infrastructure\Repository\Eloquent\TimeCast;
use Karting\Shared\Common\UUID;
use Karting\Shared\Common\UUIDCast;

/**
 * @property UUID $uuid
 * @property Time $start_time
 * @property Time $end_time
 * @property Recurrence $recurrence
 */
class Timebox extends Model implements Policy
{
    protected $fillable = [
        'uuid',
        'start_time',
        'end_time',
        'recurrence',
    ];

    protected $casts = [
        'uuid' => UUIDCast::class,
        'start_time' => TimeCast::class,
        'end_time' => TimeCast::class,
        'recurrence' => RecurrenceCast::class,
    ];

    public static function of(UUID $id, Time $startTime, Time $endTime, Recurrence $recurrence): Timebox
    {
        return new Timebox([
            'uuid' => $id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'recurrence' => $recurrence,
        ]);
    }

    public function isSatisfiedBy(CarbonPeriod $period, Collection $reservedPeriods, Slots $slots): bool
    {
        return $this->start_time->equalsDate($period->getStartDate()) &&
            $this->end_time->equalsDate($period->getEndDate()) &&
            $this->recurrence->meet($period);
    }
}
