<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Karting\Shared\ResourceId;

interface ScheduleRepository
{
    public function save(Schedule $daySchedule): void;
    public function find(ResourceId $resourceId, WeekDay $weekDay): Schedule;
}
