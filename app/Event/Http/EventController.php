<?php


namespace App\Event\Http;

use App\Event\Event;
use App\Event\EventsBetween;
use App\Event\ScheduleEvent;
use App\Shared\Common\CommandBus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class EventController
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function show(Request $request): Collection
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $eventsQuery = EventsBetween::of($from, $to);
        return $this->bus->dispatch($eventsQuery);
    }

    public function create(CreateEventRequest $request): Response
    {
        $scheduleEvent = ScheduleEvent::of($request->input('start_date'), $request->input('end_date'), $request->input('days'));
        $this->bus->dispatch($scheduleEvent);

        return new Response('', Response::HTTP_CREATED);
    }
}
