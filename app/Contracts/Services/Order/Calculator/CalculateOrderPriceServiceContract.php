<?php

declare(strict_types=1);

namespace App\Contracts\Services\Order\Calculator;

use App\DTO\Order\Register\RegisterOrderDTO;

interface CalculateOrderPriceServiceContract
{
    /**
     * @param  RegisterOrderDTO[]  $orderDTOs
     */
    public function calculate(array $orderDTOs): float;
}
