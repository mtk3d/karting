<?php

declare(strict_types=1);

namespace App\GoCart;

use App\Shared\Common\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoCart extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['uuid'])) {
            $attributes['uuid'] = UUID::random()->toString();
        }
        parent::__construct($attributes);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(GoCartReservation::class);
    }
}
