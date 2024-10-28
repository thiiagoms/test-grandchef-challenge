<?php

declare(strict_types=1);

namespace App\Contracts\Factory\Order\Register;

use App\DTO\Order\Register\RegisterOrderDTO;
use App\Factory\Order\Register\RegisterOrderFactory;

interface RegisterOrderFactoryContract
{
    public function with(array $data): RegisterOrderFactory;

    /** @return RegisterOrderDTO[] */
    public function make(): array;
}
