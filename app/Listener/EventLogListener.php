<?php

declare(strict_types=1);

namespace App\Listener;

use Illuminate\Support\Facades\Log;

class EventLogListener
{
    public function handle($event): void
    {
        Log::info('Event fired: ' . $event);
    }
}
