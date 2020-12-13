<?php

declare(strict_types=1);

namespace App\GoCart;

use App\Shared\Common\UuidsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoCart extends Model
{
    use UuidsTrait;

    protected $fillable = [
        'name',
        'description',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(GoCartReservation::class);
    }
}
