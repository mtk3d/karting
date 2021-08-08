<?php

declare(strict_types=1);

namespace Karting\Kart\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;

class CreateKart implements Command
{
    private UUID $id;
    private string $name;
    private string $description;

    public function __construct(UUID $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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
