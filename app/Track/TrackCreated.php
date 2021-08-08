<?php

declare(strict_types=1);

namespace Karting\Track;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;

class TrackCreated implements DomainEvent
{
    private UUID $eventId;
    private UUID $id;
    private string $name;
    private string $description;
    private int $slots;

    public function __construct(UUID $eventId, UUID $id, string $name, string $description, int $slots)
    {
        $this->eventId = $eventId;
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->slots = $slots;
    }

    public static function newOne(UUID $resourceId, string $name, string $description, int $slots): TrackCreated
    {
        return new TrackCreated(UUID::random(), $resourceId, $name, $description, $slots);
    }

    public function eventId(): UUID
    {
        return $this->eventId;
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
