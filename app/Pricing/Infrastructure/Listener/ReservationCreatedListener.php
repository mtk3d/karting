<?php

declare(strict_types=1);

namespace Karting\Pricing\Infrastructure\Listener;

use Karting\Pricing\Domain\Price;
use Karting\Pricing\Domain\PriceCalculated;
use Karting\Pricing\Domain\PricedItem;
use Karting\Pricing\Infrastructure\Repository\EloquentPricedItemRepository;
use Karting\Reservation\Domain\ReservationCreated;
use Karting\Shared\Common\DomainEventBus;
use Karting\Shared\Common\UUID;

class ReservationCreatedListener
{
    public function __construct(private EloquentPricedItemRepository $repository, private DomainEventBus $bus)
    {
    }

    public function handle(ReservationCreated $reservationCreated): void
    {
        $resources = $reservationCreated->karts()
            ->map(fn (string $kartId): UUID => new UUID($kartId))
            ->push($reservationCreated->track()->id());

        $items = $this->repository->findIn($resources);
        $price = $items->reduce(fn (float $carry, PricedItem $item) => $carry + $item->price()->value(), 0);
        $pricedItem = PricedItem::of($reservationCreated->reservationId()->id(), new Price($price));
        $this->repository->save($pricedItem);
        $this->bus->dispatch(PriceCalculated::newOne($reservationCreated->reservationId()->id(), $price));
    }
}
