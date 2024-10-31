<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Contracts\Repositories\Order\OrderRepositoryContract;
use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryContract
{
    protected $model = Order::class;
}
