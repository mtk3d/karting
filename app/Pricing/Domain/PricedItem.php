<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use Illuminate\Database\Eloquent\Model;
use Karting\Shared\Common\UUID;

class PricedItem extends Model
{
    protected $fillable = [
        'uuid',
        'price'
    ];

    public static function of(UUID $id, Price $price): PricedItem
    {
        return new PricedItem([
            'uuid' => $id->toString(),
            'price' => json_encode($price)
        ]);
    }

    public function id(): UUID
    {
        return new UUID($this->uuid);
    }

    public function price(): Price
    {
        return Price::fromArray(json_decode($this->price, true));
    }
}
