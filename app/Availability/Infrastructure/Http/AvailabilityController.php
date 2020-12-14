<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;


use App\Availability\Application\AvailabilityService;
use App\Shared\Http\Controller;
use App\Shared\ResourceId;

class AvailabilityController extends Controller
{
    private AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function changeResource(string $id, ChangeResourceRequest $request): void
    {
        $resourceId = ResourceId::of($id);
        if ($request->has('is_available')) {
            ((bool)$request->get('is_available'))
                ? $this->availabilityService->turnOnResource($resourceId)
                : $this->availabilityService->withdrawResource($resourceId);
        }
    }
}
