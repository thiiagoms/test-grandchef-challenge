<?php

declare(strict_types=1);

namespace App\Factories\Order\Register;

use App\Contracts\Factories\Order\Register\RegisterOrderFactoryContract;
use App\DTO\Order\Register\RegisterOrderDTO;
use App\DTO\Product\Register\RegisterProductDTO;

class RegisterOrderFactory implements RegisterOrderFactoryContract
{
    private array $data;

    public function with(array $data): RegisterOrderFactory
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return RegisterProductDTO[]
     */
    public function make(): array
    {
        $registerProductDTO = array_map(fn (array $data) => RegisterOrderDTO::fromArray($data), $this->data['products']);

        return $registerProductDTO;
    }
}
