<?php

declare(strict_types=1);

namespace Karting\Track;

use Karting\Shared\Common\UUID;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'description'
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['uuid'])) {
            $attributes['uuid'] = UUID::random()->toString();
        }

        parent::__construct($attributes);
    }
}
