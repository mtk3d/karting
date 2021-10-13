<?php

declare(strict_types=1);

namespace Tests\Unit\Availability;

use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\EveryWeek;
use Karting\Availability\Domain\Schedule\Periodicity;
use Karting\Availability\Domain\Schedule\Time;
use Karting\Availability\Domain\Schedule\Timebox;
use Karting\Availability\Domain\Schedule\WeekDay;
use PHPUnit\Framework\TestCase;

class TimeboxTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testTimeboxMeetPeriod(): void
    {
        $timebox = new Timebox(
            new Time(12, 0, 0),
            new Time(13, 0, 0),
            new Periodicity(new EveryWeek(WeekDay::FRIDAY()), new CarbonPeriod('2021-10-06 00:00', '2021-10-20 00:00'))
        );

        $result = $timebox->meet(new CarbonPeriod('2021-10-15 12:00', '2021-10-15 13:00'));

        self::assertTrue($result);
    }
}
