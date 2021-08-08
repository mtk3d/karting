<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Track;

use Illuminate\Database\Eloquent\Model;
use Karting\App\ReadModel\ResourceReservation\ResourceReservation;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $table = 'tracks_read_model';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'slots',
        'enabled'
    ];

    protected $casts = [
        'slots' => 'integer',
        'enabled' => 'boolean'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(ResourceReservation::class, 'resource_item_id', 'uuid');
    }
}
