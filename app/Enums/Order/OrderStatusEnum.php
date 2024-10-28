<?php

declare(strict_types=1);

namespace App\Enums\Order;

enum OrderStatusEnum: string
{
    case OPEN = 'open';
    case APPROVED = 'approved';
    case DONE = 'done';
    case CANCELLED = 'cancelled';
}
