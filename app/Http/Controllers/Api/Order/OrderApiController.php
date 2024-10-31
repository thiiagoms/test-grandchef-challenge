<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Requests\Order\Register\RegisterOrderRequest;
use App\Http\Requests\Order\Update\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderApiController extends BaseOrderApiController
{
    public function store(RegisterOrderRequest $request): OrderResource
    {
        $order = $this->registerOrderService
            ->with($request->validated())
            ->handle();

        return OrderResource::make($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
