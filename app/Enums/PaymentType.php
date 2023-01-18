<?php

namespace App\Enums;

enum PaymentType:string
{
    case CreditCard = 'cc';
    case Pending = 'pending';
    case Failed = 'failed';
}
