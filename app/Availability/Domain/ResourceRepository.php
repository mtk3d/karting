<?php

declare(strict_types=1);


namespace App\Availability\Domain;

use App\Shared\ResourceId;

interface ResourceRepository
{
    public function find(ResourceId $id): ResourceItem;
    public function save(ResourceItem $resource): void;
}
