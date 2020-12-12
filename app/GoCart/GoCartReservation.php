<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Shared\Common\UuidsTrait;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class GoCartReservation extends Model
{
    use UuidsTrait;

    protected $fillable = [
        'from',
        'to'
    ];

    public static function of(CarbonPeriod $period): GoCartReservation
    {
        return new GoCartReservation([
            'from' => $period->getStartDate()->toISOString(),
            'to' => $period->getEndDate()->toISOString()
        ]);
    }
}
