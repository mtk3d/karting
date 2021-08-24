<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Kart;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Karting\App\ReadModel\ResourceReservation\ResourceReservation;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property bool $enabled
 * @property string $price
 * @property Collection $reservations
 */
class Kart extends Model
{
    protected $table = 'karts_read_model';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'enabled',
        'price'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    protected $hidden = [
        'id',
        'pivot',
        'created_at',
        'updated_at',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(ResourceReservation::class, 'resource_item_id', 'uuid');
    }
}
