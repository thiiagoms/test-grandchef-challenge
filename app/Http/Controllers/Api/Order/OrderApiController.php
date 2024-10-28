<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Register\RegisterOrderRequest;
use App\Http\Requests\Order\Update\UpdateOrderRequest;
use App\Models\Order;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterOrderRequest $request)
    {
        dd($request->validated());

        // $order = Order::create([
        //     'status' => OrderStatusEnum::OPEN->value,
        //     'total_price' => 12,
        // ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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
    public function destroy(Order $order)
    {
        //
    }
}
