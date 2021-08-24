<?php

declare(strict_types=1);


namespace Karting\Shared\Common;

interface CommandBus
{
    public function dispatch(Command $command): void;
    public function map(array $map): void;
}
