<?php

declare(strict_types=1);


namespace App\Track;


use App\Shared\Common\UUID;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class TrackReservation extends Model
{
    protected $fillable = [
        'uuid',
        'from',
        'to'
    ];

    public static function of(CarbonPeriod $period): TrackReservation
    {
        return new TrackReservation([
            'uuid' => UUID::random()->toString(),
            'from' => $period->getStartDate()->toISOString(),
            'to' => $period->getEndDate()->toISOString()
        ]);
    }
}
