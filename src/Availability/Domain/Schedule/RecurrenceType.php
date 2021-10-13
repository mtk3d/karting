<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use InvalidArgumentException;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryMonth;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryWeek;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryYear;
use Karting\Availability\Domain\Schedule\RecurrenceRule\InDay;
use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 * @method static RecurrenceType EVERY_MONTH()
 * @method static RecurrenceType EVERY_WEEK()
 * @method static RecurrenceType EVERY_YEAR()
 * @method static RecurrenceType IN_DAY()
 */
class RecurrenceType extends Enum
{
    private const EVERY_MONTH = 'every_month';
    private const EVERY_WEEK = 'every_week';
    private const EVERY_YEAR = 'every_year';
    private const IN_DAY = 'in_day';

    public static function fromRule(RecurrenceRule $rule): RecurrenceType
    {
        return match ($rule::class) {
            EveryMonth::class => RecurrenceType::EVERY_MONTH(),
            EveryWeek::class => RecurrenceType::EVERY_WEEK(),
            EveryYear::class => RecurrenceType::EVERY_YEAR(),
            InDay::class => RecurrenceType::IN_DAY(),
            default => throw new InvalidArgumentException('ResourceType not found'),
        };
    }
}
