<?php

declare(strict_types=1);

namespace App\Track;

use App\Shared\Common\UuidsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    use UuidsTrait;

    protected $fillable = [
        'name',
        'description',
        'slots',
        'is_available'
    ];

    protected $casts = [
        'slots' => 'integer',
        'is_available' => 'boolean'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(TrackReservation::class);
    }
}
