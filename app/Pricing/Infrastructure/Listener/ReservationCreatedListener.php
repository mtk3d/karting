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
use Karting\Shared\ResourceId;

class ReservationCreatedListener
{
    public function __construct(private EloquentPricedItemRepository $repository, private DomainEventBus $bus)
    {
    }

    public function handle(ReservationCreated $reservationCreated): void
    {
        $resources = $reservationCreated->karts()
            ->push($reservationCreated->track())
            ->map(fn (ResourceId $resourceId): UUID => $resourceId->id());

        $items = $this->repository->findIn($resources);
        /** @var Price $price */
        $price = $items->reduce(fn (Price $sum, PricedItem $item) => $sum->add($item->price()), Price::of(0));
        $pricedItem = PricedItem::of($reservationCreated->reservationId()->id(), $price);
        $this->repository->save($pricedItem);
        $this->bus->dispatch(PriceCalculated::newOne($reservationCreated->reservationId()->id(), $price->money()));
    }
}
