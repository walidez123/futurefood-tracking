<?php

namespace App\ProvidersIntegration\Foodics\Enums;

enum TagType: int
{
    case CUSTOMER_TAG = 1;
    case BRANCH_TAG = 2;
    case INVENTORY_ITEM_TAG = 3;
    case ORDER_TAG = 4;
    case SUPPLIER_TAG = 5;
    case USER_TAG = 6;
    case PRODUCT_TAG = 7;
}
