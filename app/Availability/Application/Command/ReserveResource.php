<?php

declare(strict_types=1);


namespace App\Availability\Application\Command;

use App\Shared\Common\Command;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ReserveResource implements Command
{
    private ResourceId $id;
    private CarbonPeriod $period;

    public function __construct(ResourceId $id, CarbonPeriod $period)
    {
        $this->id = $id;
        $this->period = $period;
    }

    public static function fromRaw(string $id, string $from, string $to): ReserveResource
    {
        $id = ResourceId::of($id);
        $period = CarbonPeriod::create($from, $to);

        return new ReserveResource($id, $period);
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }
}
