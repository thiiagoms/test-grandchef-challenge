<?php

declare(strict_types=1);

namespace App\Contracts\Factories\Order\Register;

use App\DTO\Order\Register\RegisterOrderDTO;
use App\Factories\Order\Register\RegisterOrderFactory;

interface RegisterOrderFactoryContract
{
    public function with(array $data): RegisterOrderFactory;

    /** @return RegisterOrderDTO[] */
    public function make(): array;
}
