<?php

namespace App\Enums;

enum ShipmentStatus: int
{
    case UNFULFILLED = 1;
    case PARTIALLY_FULFILLED = 2;
    case FULFILLED = 3;
    case RETURNED = 4;
    case PARTIALLY_RETURNED = 5;

    public function label(): string
    {
        return match ($this) {
            self::UNFULFILLED => __('Unfulfilled'),
            self::PARTIALLY_FULFILLED => __('Partially Fulfilled'),
            self::FULFILLED => __('Fulfilled'),
            self::RETURNED => __('Returned'),
            self::PARTIALLY_RETURNED => __('Partially Returned'),
        };
    }
}
