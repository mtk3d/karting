<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Shared\Http\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class GoCartInventoryController extends Controller
{
    /**
     * @var GoCartInventory
     */
    private GoCartInventory $goCartInventory;

    public function __construct(GoCartInventory $goCartInventory)
    {
        $this->goCartInventory = $goCartInventory;
    }

    public function create(GoCartRequest $request): Response
    {
        $this->goCartInventory->create($request);
    }

    public function all(): Collection
    {
        return $this->goCartInventory->getList();
    }
}
