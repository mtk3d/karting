<?php

declare(strict_types=1);

namespace App\Shared\Common\Result;

use App\Shared\Common\Result;

final class Failure extends Result
{
    protected string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }
}
