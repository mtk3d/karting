<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Karting\App\ReadModel\Kart\Kart;
use Karting\App\ReadModel\Track\Track;

class Reservation extends Model
{
    protected $table = 'reservations_read_model';

    protected $fillable = [
        'uuid',
        'track_id',
        'from',
        'to',
        'confirmed'
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];

    protected $with = [
        'track',
        'karts'
    ];

    public function track(): HasOne
    {
        return $this->hasOne(Track::class, 'uuid', 'track_id');
    }

    public function karts(): BelongsToMany
    {
        return $this->belongsToMany(
            Kart::class,
            'reservation_kart_read_model',
            'reservation_id',
            'kart_id',
            'uuid',
            'uuid'
        );
    }
}