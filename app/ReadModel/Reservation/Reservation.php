<?php

declare(strict_types=1);

namespace App\ReadModel\Reservation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\ReadModel\Kart\Kart;
use App\ReadModel\Track\Track;

class Reservation extends Model
{
    protected $table = 'reservations_read_model';

    protected $fillable = [
        'uuid',
        'track_id',
        'from',
        'to',
        'status',
        'price'
    ];

    protected $with = [
        'track',
        'karts'
    ];

    protected $hidden = [
        'id',
        'track_id',
        'created_at',
        'updated_at',
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
