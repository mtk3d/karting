<?php

declare(strict_types=1);


namespace App\Track;


use App\Shared\Common\UuidsTrait;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class TrackReservation extends Model
{
    use UuidsTrait;

    protected $fillable = [
        'from',
        'to'
    ];

    public static function of(CarbonPeriod $period): TrackReservation
    {
        return new TrackReservation([
            'from' => $period->getStartDate()->toISOString(),
            'to' => $period->getEndDate()->toISOString()
        ]);
    }
}
