<?php

declare(strict_types=1);

namespace App\Factory\Order\Register;

use App\Contracts\Factory\Order\Register\RegisterOrderFactoryContract;
use App\DTO\Product\Register\RegisterProductDTO;

class RegisterOrderFactory implements RegisterOrderFactoryContract
{
    private array $data = [];

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
        $registerProductDTO = array_map(fn (array $data) => RegisterProductDTO::fromArray($data), $this->data);

        return $registerProductDTO;
    }
}
