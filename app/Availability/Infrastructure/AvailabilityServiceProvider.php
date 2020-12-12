<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure;

use App\Availability\Infrastructure\Listener\GoCartCreatedListener;
use App\GoCart\GoCartCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AvailabilityServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        GoCartCreated::class => [
            GoCartCreatedListener::class
        ]
    ];

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}
