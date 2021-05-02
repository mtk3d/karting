<?php

declare(strict_types=1);


namespace App\Availability\Domain;

use App\Shared\Common\UUID;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'uuid',
        'from',
        'to',
        'resource_item_id',
    ];

    public static function of(CarbonPeriod $period, ResourceId $resourceId): Reservation
    {
        return new Reservation([
            'uuid' => UUID::random()->toString(),
            'from' => $period->getStartDate()->toISOString(),
            'to' => $period->getEndDate()->toISOString(),
            'resource_item_id' => (string)$resourceId->id(),
        ]);
    }

    public function getPeriod(): CarbonPeriod
    {
        return new CarbonPeriod($this->attributes['from'], $this->attributes['to']);
    }
}
