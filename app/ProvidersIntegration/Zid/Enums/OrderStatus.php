<?php

namespace App\ProvidersIntegration\Zid\Enums;

enum OrderStatus : string
{
    case new = 'new';
    case ready = 'ready';
    case processingReverse = 'processingReverse';
    case inDelivery = 'inDelivery';
    case delivered = 'delivered';
    case canceled = 'canceled';
}
