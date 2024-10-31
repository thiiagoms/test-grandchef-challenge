<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Order;

use App\Contracts\Repositories\ReadableRepositoryContract;
use App\Contracts\Repositories\WritableRepositoryContract;

interface OrderRepositoryContract extends ReadableRepositoryContract, WritableRepositoryContract {}
