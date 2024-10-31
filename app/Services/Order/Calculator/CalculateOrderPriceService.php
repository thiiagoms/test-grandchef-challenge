<?php

declare(strict_types=1);

namespace App\Services\Order\Calculator;

use App\Contracts\Services\Order\Calculator\CalculateOrderPriceServiceContract;

class CalculateOrderPriceService implements CalculateOrderPriceServiceContract
{
    public function calculate(array $orderDTOs): float
    {
        return array_reduce(
            $orderDTOs,
            fn (float $total, $orderDTO): float => $total + ($orderDTO->quantity * $orderDTO->price),
            0.0
        );
    }
}
