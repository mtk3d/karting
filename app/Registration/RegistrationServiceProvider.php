<?php

declare(strict_types=1);


namespace App\Registration;


use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RegistrationServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ]
    ];

    /**
     * @return void
     */
    public function boot()
    {

    }
}
