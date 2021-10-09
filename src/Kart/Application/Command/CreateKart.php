<?php

declare(strict_types=1);

namespace Karting\Kart\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;

class CreateKart implements Command
{
    public function __construct(private UUID $id, private string $name, private string $description)
    {
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }
}
