<?php


namespace App\Event;


use App\Shared\Common\UUID;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'uuid',
        'start_date',
        'end_date',
        'days',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'days' => 'collection'
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['uuid'])) {
            $attributes['uuid'] = UUID::random()->toString();
        }

        parent::__construct($attributes);
    }
}
