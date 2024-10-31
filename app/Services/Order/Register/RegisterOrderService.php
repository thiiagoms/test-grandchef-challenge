<?php

declare(strict_types=1);

namespace App\Services\Order\Register;

use App\Contracts\Factories\Order\Register\RegisterOrderFactoryContract;
use App\Contracts\Repositories\Order\OrderRepositoryContract;
use App\Contracts\Services\Order\Calculator\CalculateOrderPriceServiceContract;
use App\Contracts\Services\Order\Register\RegisterOrderServiceContract;
use App\DTO\Order\Register\RegisterOrderDTO;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order;

class RegisterOrderService implements RegisterOrderServiceContract
{
    private array $data = [];

    public function __construct(
        private readonly RegisterOrderFactoryContract $orderFactory,
        private readonly CalculateOrderPriceServiceContract $calculateOrderPrice,
        private readonly OrderRepositoryContract $orderRepository,
    ) {}

    public function with(array $orderSet): RegisterOrderService
    {
        $this->data = $orderSet;

        return $this;
    }

    private function createOrder(float $total): Order
    {
        return $this->orderRepository->create(['total_price' => $total, 'status' => OrderStatusEnum::OPEN]);
    }

    private function attachProducts(Order $order, array $orderDTOs): void
    {
        array_walk($orderDTOs, fn (RegisterOrderDTO $orderDTO) => $order->products()->attach($orderDTO->product_id, [
            'quantity' => $orderDTO->quantity,
            'price' => $orderDTO->price,
        ]));
    }

    public function handle(): Order
    {
        $orderDTOs = $this->orderFactory->with($this->data)->make();

        $total = $this->calculateOrderPrice->calculate($orderDTOs);

        $order = $this->createOrder($total);

        $this->attachProducts($order, $orderDTOs);

        return $order;
    }
}
