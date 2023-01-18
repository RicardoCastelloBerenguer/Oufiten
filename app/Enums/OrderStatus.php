<?php

namespace App\Enums;

enum OrderStatus:string
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
}
