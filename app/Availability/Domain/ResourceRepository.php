<?php

declare(strict_types=1);


namespace Karting\Availability\Domain;

use Karting\Shared\ResourceId;

interface ResourceRepository
{
    public function find(ResourceId $id): ResourceItem;
    public function save(ResourceItem $resource): void;
}
