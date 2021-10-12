<?php

declare(strict_types=1);

namespace Karting\Kart;

use Illuminate\Database\Eloquent\Collection;
use Karting\Shared\Common\UUID;
use Illuminate\Database\Eloquent\Model;

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

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['uuid'])) {
            $attributes['uuid'] = UUID::random()->toString();
        }
        parent::__construct($attributes);
    }
}
