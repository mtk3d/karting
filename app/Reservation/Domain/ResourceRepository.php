<?php

declare(strict_types=1);


namespace App\Reservation\Domain;


interface ResourceRepository
{
    public function save(ResourceItem $resourceItem): void;
}
