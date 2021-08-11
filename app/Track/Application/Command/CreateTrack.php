<?php

declare(strict_types=1);

namespace Karting\Track\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;

class CreateTrack implements Command
{
    public function __construct(private UUID $id, private string $name, private string $description, private int $slots)
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

    public function slots(): int
    {
        return $this->slots;
    }
}
