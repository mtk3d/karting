<?php

declare(strict_types=1);

namespace Tests\Unit\Availability;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\Recurrence;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryMonth;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryWeek;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryYear;
use Karting\Availability\Domain\Schedule\RecurrenceRule\InDay;
use Karting\Availability\Domain\Schedule\RecurrenceRule\WeekDay;
use Karting\Availability\Domain\Schedule\Time;
use Karting\Availability\Domain\Schedule\Timebox;
use Karting\Availability\Domain\Slots;
use Karting\Shared\Common\UUID;
use PHPUnit\Framework\TestCase;

class TimeboxTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testTimeboxRecurrenceEveryWeek(): void
    {
        $timebox = Timebox::of(
            UUID::random(),
            new Time(12, 0, 0),
            new Time(13, 0, 0),
            new Recurrence(
                new EveryWeek(WeekDay::FRIDAY()),
                new CarbonPeriod('2021-10-00 00:00', '2021-10-20 00:00')
            )
        );

        $satisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-15 12:00', '2021-10-15 13:00'), collect(), Slots::of(0));
        $nonSatisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-15 12:01', '2021-10-15 13:01'), collect(), Slots::of(0));

        self::assertTrue($satisfied);
        self::assertFalse($nonSatisfied);
    }

    public function testTimeboxRecurrenceEveryMonth(): void
    {
        $timebox = Timebox::of(
            UUID::random(),
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Recurrence(
                new EveryMonth(WeekDay::SUNDAY(), 1),
                new CarbonPeriod('2021-10-01 00:00', '2021-10-20 00:00')
            )
        );

        $satisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-03 10:00', '2021-10-03 11:00'), collect(), Slots::of(0));
        $nonSatisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-10 10:00', '2021-10-10 11:00'), collect(), Slots::of(0));

        self::assertTrue($satisfied);
        self::assertFalse($nonSatisfied);
    }

    public function testTimeboxRecurrenceEveryYear(): void
    {
        $timebox = Timebox::of(
            UUID::random(),
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Recurrence(
                new EveryYear(new Carbon('2021-10-05 00:00')),
                new CarbonPeriod('2021-10-01 00:00', '2021-10-20 00:00')
            )
        );

        $satisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-05 10:00', '2021-10-05 11:00'), collect(), Slots::of(0));
        $nonSatisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-03 10:00', '2021-10-03 11:00'), collect(), Slots::of(0));

        self::assertTrue($satisfied);
        self::assertFalse($nonSatisfied);
    }

    public function testTimeboxRecurrenceInDay(): void
    {
        $timebox = Timebox::of(
            UUID::random(),
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Recurrence(
                new InDay(new Carbon('2021-10-05 00:00')),
                new CarbonPeriod('2021-10-01 00:00', '2021-11-20 00:00')
            )
        );

        $satisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2021-10-05 10:00', '2021-10-05 11:00'), collect(), Slots::of(0));
        $nonSatisfied = $timebox->isSatisfiedBy(new CarbonPeriod('2022-10-05 10:00', '2022-10-05 11:00'), collect(), Slots::of(0));

        self::assertTrue($satisfied);
        self::assertFalse($nonSatisfied);
    }
}
