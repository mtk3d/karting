<?php


namespace App\Event;

use Illuminate\Support\Collection;

class EventBetweenHandler
{
    /**
     * @return Collection<int, Event>
     */
    public function handle(EventsBetween $query): Collection
    {
        $between = $query->getBetweenDates();
        $events = Event::whereBetween('start_date', $between)
            ->orWhereBetween('end_date', $between)
            ->get();

        return collect();
    }
}
