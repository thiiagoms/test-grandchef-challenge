<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\Services\Order\Register\RegisterOrderServiceContract;
use App\Http\Controllers\Controller;

abstract class BaseOrderApiController extends Controller
{
    public function __construct(
        protected readonly RegisterOrderServiceContract $registerOrderService
    ) {}
}
