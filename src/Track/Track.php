<?php

declare(strict_types=1);

namespace Karting\Track;

use Illuminate\Database\Eloquent\Collection;
use Karting\Shared\Common\UUID;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property int $slots
 * @property bool $enabled
 * @property string $price
 * @property Collection $reservations
 */
class Track extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'slots',
        'enabled',
        'price'
    ];

    protected $casts = [
        'slots' => 'integer',
        'enabled' => 'boolean'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['uuid'])) {
            $attributes['uuid'] = UUID::random()->toString();
        }

        parent::__construct($attributes);
    }
}
