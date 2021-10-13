<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'uuid',
        'timeboxes',
    ];
}
