<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case UNPAID = 1;
    case PARTIAL = 2;
    case PAID = 3;
    case REFUNDED = 4;

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => __('Unpaid'),
            self::PARTIAL => __('Partial'),
            self::PAID => __('Paid'),
            self::REFUNDED => __('Refunded'),
        };
    }
}
