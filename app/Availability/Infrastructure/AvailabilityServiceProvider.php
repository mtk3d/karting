<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure;

use App\Availability\Domain\ResourceRepository;
use App\Availability\Infrastructure\Repository\EloquentResourceRepository;
use Illuminate\Support\ServiceProvider;

class AvailabilityServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        ResourceRepository::class => EloquentResourceRepository::class,
    ];
}
