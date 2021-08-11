<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\ResourceReservation;

use Illuminate\Database\Eloquent\Model;

class ResourceReservation extends Model
{
    protected $table = 'resource_reservations_read_model';

    protected $fillable = [
        'uuid',
        'from',
        'to',
        'resource_item_id',
        'reservation_id'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
