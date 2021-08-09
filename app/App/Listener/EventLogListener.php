<?php

declare(strict_types=1);

namespace Karting\App\Listener;

use Illuminate\Support\Facades\Log;

class EventLogListener
{
    public function handle($event): void
    {
        Log::info('Event fired: ' . $event);
    }
}
