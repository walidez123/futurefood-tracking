<?php

namespace App\ProvidersIntegration\Foodics\Enums;

/**
 * Enum OrderStatus
 *
 * Represents the status of an order in Foodics system
 */
enum OrderStatus: int
{
    case Pending = 1;
    case Active = 2;
    case Declined = 3;
    case Closed = 4;
    case Returned = 5;
    case Joined = 6;
    case Void = 7;
}
