<?php

declare(strict_types=1);

namespace Tests\Unit\Pricing;

use Karting\Pricing\Application\Command\SetPrice;
use Karting\Pricing\Application\SetPriceHandler;
use Karting\Pricing\Domain\Price;
use Karting\Pricing\Domain\PricedItem;
use Karting\Pricing\Domain\PriceSet;
use Karting\Pricing\Infrastructure\Repository\InMemoryPricedItemRepository;
use Karting\Shared\Common\InMemoryDomainEventBus;
use Karting\Shared\Common\UUID;
use Money\Money;
use PHPUnit\Framework\TestCase;

class PricedItemTest extends TestCase
{
    private InMemoryPricedItemRepository $repository;
    private InMemoryDomainEventBus $bus;
    private SetPriceHandler $setPriceHandler;

    public function setUp(): void
    {
        $this->repository = new InMemoryPricedItemRepository();
        $this->bus = new InMemoryDomainEventBus();
        $this->setPriceHandler = new SetPriceHandler($this->repository, $this->bus);
    }

    public function testSetPrice(): void
    {
        $id = UUID::random();
        $price = Price::of(10);
        $event = new SetPrice($id, $price);
        $this->setPriceHandler->handle($event);

        self::assertEquals(new PriceSet($this->bus->first()->eventId(), $id, $price->money()), $this->bus->first());
        self::assertEquals(PricedItem::of($id, $price), $this->repository->find($id));
    }
}
