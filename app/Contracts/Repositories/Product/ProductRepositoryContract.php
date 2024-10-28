<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Product;

use App\Contracts\Repositories\ReadableRepositoryContract;
use App\Contracts\Repositories\WritableRepositoryContract;

interface ProductRepositoryContract extends ReadableRepositoryContract, WritableRepositoryContract {}
