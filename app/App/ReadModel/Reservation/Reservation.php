<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations_read_model';

    protected $fillable = [
        'uuid',
        'from',
        'to',
        'resource_item_id',
    ];
}
