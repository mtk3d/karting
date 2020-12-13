<?php

declare(strict_types=1);


namespace App\App;

use App\Availability\Domain\ResourceReserved;
use App\Availability\Infrastructure\Listener\GoCartCreatedListener;
use App\GoCart\GoCartCreated;
use App\GoCart\ResourceReservedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        GoCartCreated::class => [
            GoCartCreatedListener::class
        ],
        ResourceReserved::class => [
            ResourceReservedListener::class
        ],
    ];
}
