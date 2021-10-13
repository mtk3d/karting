<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 * @method static WeekDay MONDAY()
 * @method static WeekDay TUESDAY()
 * @method static WeekDay WEDNESDAY()
 * @method static WeekDay THURSDAY()
 * @method static WeekDay FRIDAY()
 * @method static WeekDay SATURDAY()
 * @method static WeekDay SUNDAY()
 */
class WeekDay extends Enum
{
    private const MONDAY = 1;
    private const TUESDAY = 2;
    private const WEDNESDAY = 3;
    private const THURSDAY = 4;
    private const FRIDAY = 5;
    private const SATURDAY = 6;
    private const SUNDAY = 0;
}
