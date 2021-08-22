<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static Status IN_PROGRESS()
 * @method static Status CONFIRMED()
 * @method static Status CANCELED()
 */
class Status extends Enum
{
    private const IN_PROGRESS = 'in_progress';
    private const CONFIRMED = 'confirmed';
    private const CANCELED = 'canceled';
}
