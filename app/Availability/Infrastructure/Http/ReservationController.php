<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;


use App\Availability\Application\AvailabilityFacade;
use App\Shared\Http\Controller;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ReservationController extends Controller
{
    private AvailabilityFacade $availabilityFacade;

    public function __construct(AvailabilityFacade $availabilityFacade)
    {
        $this->availabilityFacade = $availabilityFacade;
    }

    public function reserve(string $id, ReservationRequest $request): void
    {
        $period = CarbonPeriod::create($request->get('from'), $request->get('to'));

        $this->availabilityFacade->reserve(ResourceId::of($id), $period);
    }
}
