<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;


use App\Availability\Application\ReservationService;
use App\Shared\Http\Controller;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ReservationController extends Controller
{
    private ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function reserve(string $id, ReservationRequest $request): void
    {
        $period = CarbonPeriod::create($request->get('from'), $request->get('to'));

        $this->reservationService->reserve(ResourceId::of($id), $period);
    }
}
