<?php

declare(strict_types=1);

namespace App\Event;

use App\Shared\Common\CommandBus;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            ScheduleEvent::class => ScheduleEventHandler::class,
            EventsBetween::class => EventBetweenHandler::class
        ]);
    }
}
