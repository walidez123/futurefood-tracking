<?php

namespace App\ProvidersIntegration\Foodics\Enums;

enum OrderDeliveryStatus: int
{
    case SENT_TO_KITCHEN = 1;
    case READY = 2;
    case ASSIGNED = 3;
    case EN_ROUTE = 4;
    case DELIVERED = 5;
    case CLOSED = 6;
}
