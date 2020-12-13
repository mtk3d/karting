<?php

declare(strict_types=1);


namespace App\Shared\Common;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DomainEventDispatcher::class, IlluminateDomainEventDispatcher::class);
    }
}
