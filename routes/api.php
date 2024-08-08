<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/calculate-distance', 'App\Http\Controllers\Api\DistanceMatrixController@calculateDistance');
Route::post('/FutureExpressDelivery/UpdateFutureExpressDeliveryOrderStatus', 'App\Http\Controllers\Api\RabihWebhookController@handle');



//webhook
Route::post('/webhook-update-order-status', 'App\Http\Controllers\Api\WebhookController@handle');
Route::middleware('localization')->group(function () {

    Route::get('/App_setting', 'App\Http\Controllers\Api\SettingController@Setting');
    Route::get('/cities', 'App\Http\Controllers\Api\CityController@cities');
    Route::get('/regions/{city_id}', 'App\Http\Controllers\Api\CityController@regions');
    Route::post('/check_token', 'App\Http\Controllers\Api\NotificationController@check_token');
    Route::get('/notifications', 'App\Http\Controllers\Api\NotificationController@notifications');
    Route::get('/notifications/{notification}', 'App\Http\Controllers\Api\NotificationController@notification_show');
    Route::post('/Token_Device', 'App\Http\Controllers\Api\NotificationController@tokenDevice');
    Route::post('/Request_join_service_provider', 'App\Http\Controllers\Api\Request_join_service_providerController@store');
    Route::post('/smp/login', 'App\Http\Controllers\Api\Service_provider\AuthController@login');
    Route::post('/smp/updateOrderStatus', 'App\Http\Controllers\Api\Service_provider\OrderController@updateOrderStatus');


    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    // delegate
    Route::prefix('v1')->namespace('App\Http\Controllers\Api')->group(function () {
        // auth apis

        Route::post('/login', 'Mobile\AuthController@login');
        Route::post('/logout', 'Mobile\AuthController@logout');
        Route::post('/forget-password', 'Mobile\AuthController@forgetPassword');
        Route::post('/reset-password', 'Mobile\AuthController@resetPassword');
        Route::post('/request_join', 'Mobile\AuthController@request_join');
        Route::get('/profile', 'Mobile\AuthController@profile');
        // profiles
        Route::post('/profile/update', 'Mobile\ProfileController@update');
        Route::post('/change-password', 'Mobile\ProfileController@changePassword');
        Route::get('/user/statistics', 'Mobile\AuthController@analytics');
        Route::get('/balance', 'Mobile\ProfileController@balance');
        Route::post('/location', 'Mobile\AuthController@location');
        Route::post('/contact_us', 'Mobile\ProfileController@contact_us');

        // orders
        Route::get('/orders', 'Mobile\OrderController@index');
        Route::post('/order_details', 'Mobile\OrderController@details');

        Route::get('/git_orders_status', 'Mobile\OrderController@git_orders_status');
        Route::get('/Daily/orders', 'Mobile\OrderController@Daily');
        Route::get('/daily/store/status/orders', 'Mobile\OrderController@dailyStoreStatusOrders');
        Route::get('daily/restaurant/status/orders', 'Mobile\OrderController@dailyRestaurantStatusOrders');
        // dailyStoreStatusesOrdersWithCount
        Route::get('daily/store/statuses/orders', 'Mobile\OrderController@dailyStoreStatusesOrdersWithCount');

        Route::post('/orders/pickup', 'Mobile\OrderController@pickup');
        Route::get('/orders/pickup', 'Mobile\OrderController@pickuporders');
        Route::post('/otp_code', 'Mobile\OrderController@otp_code');
        Route::post('/real_image', 'Mobile\OrderController@real_image');
        Route::post('/payment_method', 'Mobile\OrderController@payment_method');
        Route::post('/orders/update', 'Mobile\OrderController@update');
        Route::post('/orders-list/update', 'Mobile\OrderController@updateList');
        Route::post('/orders-list-v2/update', 'Mobile\OrderController@updateListV2');
        Route::get('/statuses', 'Mobile\OrderController@statuses');
        Route::get('/blink-statuses', 'Mobile\OrderController@blinkStatuses');
        Route::post('/search', 'Mobile\OrderController@search');
        Route::post('/orders/contact-count', 'Mobile\OrderController@contactCount');
        Route::get('/order/comments', 'Mobile\OrderController@comments');
        Route::post('/order/comment/store', 'Mobile\OrderController@storeComment');
        Route::get('/Reports', 'Mobile\ReportsController@index');
        Route::get('/Reports/search', 'Mobile\ReportsController@search');
        Route::post('/Reports/store', 'Mobile\ReportsController@store');
        Route::post('/Reports/update', 'Mobile\ReportsController@update');
        Route::get('/Client_Delegate', 'Mobile\ReportsController@Client_Delegate');
        //orders_restaurant
        Route::get('/orders_restaurant', 'Mobile\orders_restaurantController@index');
        Route::post('/order_restaurant_details', 'Mobile\orders_restaurantController@details');

        Route::get('/Daily/orders_restaurant', 'Mobile\orders_restaurantController@Daily');
        Route::get('/new/orders_restaurant', 'Mobile\orders_restaurantController@new');
        Route::post('/status/orders_res', 'Mobile\orders_restaurantController@status_order');


    });

    // client
    Route::prefix('store/v1')->namespace('App\Http\Controllers\Api')->group(function () {

        Route::post('/login', 'Store\AuthController@login');
        Route::post('/logout', 'Store\AuthController@logout');
        Route::post('/forget-password', 'Store\AuthController@forgetPassword');
        Route::post('/reset-password', 'Store\AuthController@resetPassword');
        Route::post('/contact_us', 'Mobile\ProfileController@contact_us');
        // profiles
        Route::post('/profile/update', 'Store\ProfileController@update');
        Route::post('/change-password', 'Store\ProfileController@changePassword');
        Route::get('/user/statistics', 'Store\AuthController@analytics');
        Route::get('/balance', 'Store\ProfileController@balance');
        Route::get('/notifications', 'Store\ProfileController@notifications');
        Route::get('/notifications/{notification}', 'Store\ProfileController@notification_show');
        Route::get('/branches', 'Store\ProfileController@branches');
        Route::get('/address', 'Store\AddressController@index');
        Route::post('/address/create', 'Store\AddressController@store');
        Route::get('/goods', 'Store\GoodsController@index');
        Route::get('/goods_store_warehouse', 'Store\GoodStoreWarehouseController@index');

        Route::get('/order', 'Store\OrderController@index');
        Route::post('/order_details', 'Store\OrderController@details');

        Route::post('/order', 'Store\OrderController@store');
        Route::post('/order/update-order-status', 'Store\OrderController@updateOrderStatus');
        Route::post('/order/update-order-to-paid', 'Store\OrderController@updateOrderToPaid');
        Route::get('/search', 'Store\OrderController@search');
        Route::get('/Daily/orders', 'Store\OrderController@Daily');
        Route::get('/order_tracking', 'Store\OrderController@order_tracking');
        Route::post('/new_order', 'Store\OrderController@resturantOrder');
        Route::post('/new_fulfillment_order', 'Store\OrderController@fulfillmentOrderStore');
        Route::get('/Reports', 'Store\ReportsController@index');
        Route::get('/Reports/search', 'Store\ReportsController@search');
        Route::get('/Client_Delegate', 'Store\ReportsController@Client_Delegate');
        // updateOrderPaid

    });

    //for employee warehouse
    Route::prefix('Warehouse_employee/v1')->namespace('App\Http\Controllers\Api')->group(function () {
        Route::post('/login', 'Warehouse_employee\AuthController@login');
        Route::post('/logout', 'Warehouse_employee\AuthController@logout');
        Route::post('/forget-password', 'Warehouse_employee\AuthController@forgetPassword');
        Route::post('/reset-password', 'Warehouse_employee\AuthController@resetPassword');
        Route::get('/profile', 'Warehouse_employee\AuthController@profile');
        // profiles
        Route::post('/profile/update', 'Warehouse_employee\ProfileController@update');
        Route::post('/change-password', 'Warehouse_employee\ProfileController@changePassword');
        //warehouse_branches
        Route::get('/warehouse-branches', 'Warehouse_employee\WarehouseBranchesController@index');
        Route::get('/fuliflment-warehouse_branch', 'Warehouse_employee\WarehouseBranchesController@fuliflment');
        Route::get('/warehouse-warehouse_branch', 'Warehouse_employee\WarehouseBranchesController@warehouse');
        Route::get('/warehouse_packages', 'Warehouse_employee\WarehouseBranchesController@warehouse_packages');
        //goods
        Route::get('/warehouse-goods', 'Warehouse_employee\GoodsController@index');
        Route::post('/warehouse-search-goods', 'Warehouse_employee\GoodsController@goodSearch');
        Route::post('/warehouse-search-client-goods', 'Warehouse_employee\GoodsController@clientSearch');
        // Housing goods
        Route::get('/warehouse-clients', 'Warehouse_employee\warehouse_clientsController@warehouse');
        Route::get('/fuliflment-clients', 'Warehouse_employee\warehouse_clientsController@fuliflment');
        Route::get('/fuliflment-goods', 'Warehouse_employee\warehouse_clientsController@fuliflment_goods');
        Route::post('/Housing-goods', 'Warehouse_employee\warehouse_clientsController@store');
        Route::get('/Housing-goods_fuliflment', 'Warehouse_employee\warehouse_clientsController@list_fuliflment');
        Route::get('/Housing-goods_warehouse', 'Warehouse_employee\warehouse_clientsController@list_warehouse');
        Route::get('/warehouse_client_free_area', 'Warehouse_employee\warehouse_clientsController@free_area');

    });

});

Route::get('/language', 'App\Http\Controllers\Api\LanguageController@changeLanguage');



//delegate api v2 
  // delegate
  Route::prefix('v2')->namespace('App\Http\Controllers\Api\v2')->group(function () {
    // auth apis

    Route::post('/login', 'Mobile\AuthController@login');
    Route::post('/logout', 'Mobile\AuthController@logout');
    Route::post('/forget-password', 'Mobile\AuthController@forgetPassword');
    Route::post('/reset-password', 'Mobile\AuthController@resetPassword');
    Route::post('/request_join', 'Mobile\AuthController@request_join');
    Route::get('/profile', 'Mobile\AuthController@profile');

 


    // profiles
    Route::post('/profile/update', 'Mobile\ProfileController@update');
    Route::post('/change-password', 'Mobile\ProfileController@changePassword');
    Route::get('/user/statistics', 'Mobile\AuthController@analytics');
    Route::get('/balance', 'Mobile\ProfileController@balance');
    Route::post('/location', 'Mobile\AuthController@location');
    Route::post('/contact_us', 'Mobile\ProfileController@contact_us');

    // orders
    Route::get('/orders', 'Mobile\OrderController@index');
    Route::get('/git_orders_status', 'Mobile\OrderController@git_orders_status');
    Route::get('store/git_orders_status', 'Mobile\OrderController@git_orders_status');
    Route::get('restaurant/git_orders_status', 'Mobile\orders_restaurantController@git_orders_status');
    Route::get('fulfilment/git_orders_status', 'Mobile\orders_fulfilmentController@git_orders_status');


    Route::get('store/Order_closing_status', 'Mobile\Order_closing_statusController@store');
    Route::get('restaurant/Order_closing_status', 'Mobile\Order_closing_statusController@restaurant');
    Route::get('fulfilment/Order_closing_status', 'Mobile\Order_closing_statusController@fulfilment');


    Route::post('/order_details', 'Mobile\OrderController@details');

    Route::get('/Daily/orders', 'Mobile\OrderController@Daily');
    Route::get('/daily/store/status/orders', 'Mobile\OrderController@dailyStoreStatusOrders');
    Route::get('daily/restaurant/status/orders', 'Mobile\OrderController@dailyRestaurantStatusOrders');
    Route::post('/orders/pickup', 'Mobile\OrderController@pickup');
    Route::get('/orders/pickup', 'Mobile\OrderController@pickuporders');
    Route::post('/otp_code', 'Mobile\OrderController@otp_code');
    Route::post('/real_image', 'Mobile\OrderController@real_image');
    Route::post('/payment_method', 'Mobile\OrderController@payment_method');
    Route::post('/orders/update', 'Mobile\OrderController@update');
    Route::post('/orders-list/update', 'Mobile\OrderController@updateList');
    Route::post('/orders-list-v2/update', 'Mobile\OrderController@updateListV2');
    Route::get('/statuses', 'Mobile\OrderController@statuses');
    Route::get('/blink-statuses', 'Mobile\OrderController@blinkStatuses');
    Route::post('/search', 'Mobile\OrderController@search');
    Route::post('/search-orders', 'Mobile\OrderController@searchOrders');
    Route::post('/orders/contact-count', 'Mobile\OrderController@contactCount');
    Route::get('/order/comments', 'Mobile\OrderController@comments');
    Route::post('/order/comment/store', 'Mobile\OrderController@storeComment');
    Route::get('/Reports', 'Mobile\ReportsController@index');
    Route::get('/Reports/search', 'Mobile\ReportsController@search');
    Route::post('/Reports/store', 'Mobile\ReportsController@store');
    Route::post('/Reports/update', 'Mobile\ReportsController@update');
    Route::get('/Client_Delegate', 'Mobile\ReportsController@Client_Delegate');
    //orders_restaurant
    Route::get('/orders_restaurant', 'Mobile\orders_restaurantController@index');
    Route::post('/order_restaurant_details', 'Mobile\orders_restaurantController@details');
    Route::get('/Daily/orders_restaurant', 'Mobile\orders_restaurantController@Daily');
    Route::get('/new/orders_restaurant', 'Mobile\orders_restaurantController@new');
    Route::post('/status/orders_res', 'Mobile\orders_restaurantController@status_order');

    // orders_fulfement
    //orders_restaurant
    Route::get('/orders_fulfilment', 'Mobile\orders_fulfilmentController@index');
    Route::post('/order_fulfilment_details', 'Mobile\orders_fulfilmentController@details');
    Route::get('/pickup_orders_fulfilment', 'Mobile\orders_fulfilmentController@pickuporders');
    Route::get('/new/orders_fulfilment', 'Mobile\orders_fulfilmentController@new');
    Route::post('/status/orders_fulfilment', 'Mobile\orders_fulfilmentController@status_order');


});