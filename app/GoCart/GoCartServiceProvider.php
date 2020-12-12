<?php

declare(strict_types=1);


namespace App\GoCart;


use App\Availability\Domain\ResourceReserved;
use App\Shared\Http\ApiRateLimitingTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class GoCartServiceProvider extends ServiceProvider
{
    use ApiRateLimitingTrait;
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\GoCart';

    /**
     * @var array
     */
    protected $listen = [
        ResourceReserved::class => [
            ResourceReservedListener::class
        ]
    ];

    /**
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/go-cart-api.php'));
        });
    }
}
