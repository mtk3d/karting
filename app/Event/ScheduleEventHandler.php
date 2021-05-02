<?php


namespace App\Event;

use App\Shared\Common\UUID;

class ScheduleEventHandler
{
    public function handle(ScheduleEvent $scheduleRace): void
    {
        $race = new Event([
            'uuid' => UUID::random()->toString(),
            'start_date' => $scheduleRace->getStartDate(),
            'end_date' => $scheduleRace->getEndDate(),
            'days' => $scheduleRace->getDays()
        ]);

        $race->save();
    }
}
