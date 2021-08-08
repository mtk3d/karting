<?php

declare(strict_types=1);

namespace Karting\Shared\Common\Result;

use Karting\Shared\Common\Result;

final class Failure extends Result
{
    protected string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }
}
