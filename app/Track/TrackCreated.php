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

    public function __construct(UUID $eventId, UUID $id, string $name, string $description)
    {
        $this->eventId = $eventId;
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public static function newOne(UUID $resourceId, string $name, string $description): TrackCreated
    {
        return new TrackCreated(UUID::random(), $resourceId, $name, $description);
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
}
