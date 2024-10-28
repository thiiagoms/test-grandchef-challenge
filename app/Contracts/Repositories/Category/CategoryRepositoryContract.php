<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Category;

use App\Contracts\Repositories\ReadableRepositoryContract;
use App\Contracts\Repositories\WritableRepositoryContract;

interface CategoryRepositoryContract extends ReadableRepositoryContract, WritableRepositoryContract {}
