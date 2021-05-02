<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Shared\Common\UUID;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class GoCartReservation extends Model
{
    protected $fillable = [
        'uuid',
        'from',
        'to'
    ];

    public static function of(CarbonPeriod $period): GoCartReservation
    {
        return new GoCartReservation([
            'uuid' => UUID::random()->toString(),
            'from' => $period->getStartDate()->toISOString(),
            'to' => $period->getEndDate()->toISOString()
        ]);
    }
}
