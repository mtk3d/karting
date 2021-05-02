<?php


namespace App\Event;


use MyCLabs\Enum\Enum;

/**
 * @method static Day MONDAY()
 * @method static Day TUESDAY()
 * @method static Day WEDNESDAY()
 * @method static Day THURSDAY()
 * @method static Day FRIDAY()
 * @method static Day SATURDAY()
 * @method static Day SUNDAY()
 */
class Day extends Enum
{
    private const MONDAY = 'monday';
    private const TUESDAY = 'tuesday';
    private const WEDNESDAY = 'wednesday';
    private const THURSDAY = 'thursday';
    private const FRIDAY = 'friday';
    private const SATURDAY = 'saturday';
    private const SUNDAY = 'sunday';
}
