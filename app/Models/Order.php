<?php

namespace App\Models;

use App\Enums\Order\OrderStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'status',
        'total_price',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $status): OrderStatusEnum => OrderStatusEnum::from($status),
            set: fn (OrderStatusEnum $status): string => $status->value
        );
    }
}
