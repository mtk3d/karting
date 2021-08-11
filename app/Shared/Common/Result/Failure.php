<?php

declare(strict_types=1);

namespace Karting\Shared\Common\Result;

use Karting\Shared\Common\Result;

final class Failure extends Result
{
    public function __construct(protected string $reason)
    {
    }
}
