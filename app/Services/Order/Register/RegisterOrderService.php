<?php

declare(strict_types=1);

namespace App\Services\Order\Register;

use App\Contracts\Factory\Order\Register\RegisterOrderFactoryContract;
use App\Contracts\Services\Order\Register\RegisterOrderServiceContract;
use App\Models\Order;

class RegisterOrderService implements RegisterOrderServiceContract
{
    public function __construct(
        private readonly RegisterOrderFactoryContract $registerOrderFactory
        // Classe para calcular o valor total
        // Cadastro de todos os pedidos
    ) {}

    public function handle(): Order
    {
        return new Order;
    }
}
