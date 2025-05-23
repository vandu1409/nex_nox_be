<?php

namespace App\Enums;

enum BookingType: string
{
    case Hourly = 'hourly';
    case Overnight = 'overnight';
    case Daily = 'daily';
}
