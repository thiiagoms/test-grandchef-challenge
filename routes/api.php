<?php

use App\Http\Controllers\Api\Category\CategoryApiController;
use App\Http\Controllers\Api\Order\OrderApiController;
use App\Http\Controllers\Api\Product\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('products', ProductApiController::class);
Route::apiResource('orders', OrderApiController::class);
