<?php

declare(strict_types=1);


namespace App\Shared\Common;

interface CommandBus
{
    public function dispatch(Command $command);
    public function map(array $map): void;
}
