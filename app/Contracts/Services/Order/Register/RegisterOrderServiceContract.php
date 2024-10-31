<?php

declare(strict_types=1);

namespace App\Contracts\Services\Order\Register;

use App\Models\Order;
use App\Services\Order\Register\RegisterOrderService;

interface RegisterOrderServiceContract
{
    public function with(array $orderSet): RegisterOrderService;

    public function handle(): Order;
}
