<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
{
    protected $model = Product::class;
}
