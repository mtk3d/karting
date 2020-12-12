<?php

declare(strict_types=1);

namespace App\Shared\Result;

use App\Shared\Result;

final class Failure extends Result
{
    protected string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }
}
