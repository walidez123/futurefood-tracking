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
    Route::get('/language', 'App\Http\Controllers\Api\LanguageController@changeLanguage');



    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    // delegate

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

 




    Route::post('/order_details', 'Mobile\OrderController@details');
    Route::post('/otp_code', 'Mobile\OrderController@otp_code');
    Route::post('/real_image', 'Mobile\OrderController@real_image');
    Route::post('/payment_method', 'Mobile\OrderController@payment_method');

    Route::get('/statuses', 'Mobile\OrderController@statuses');
    Route::get('/blink-statuses', 'Mobile\OrderController@blinkStatuses');
    Route::post('/search', 'Mobile\OrderController@search');
    Route::post('/search-orders', 'Mobile\OrderController@searchOrders');

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
    Route::post('/status/orders_restaurant', 'Mobile\orders_restaurantController@status_order');
    Route::post('/orders/update', 'Mobile\orders_restaurantController@update');
    Route::post('/orders-list/update', 'Mobile\orders_restaurantController@updateList');
    Route::post('/orders/contact-count', 'Mobile\orders_restaurantController@contactCount');
    Route::get('/order/comments', 'Mobile\orders_restaurantController@comments');
    Route::post('/order/comment/store', 'Mobile\orders_restaurantController@storeComment');



});
  

    // client
    Route::prefix('resturant/v1')->namespace('App\Http\Controllers\Api')->group(function () {

        Route::post('/login', 'Resturant\AuthController@login');
        Route::post('/logout', 'Resturant\AuthController@logout');
        Route::post('/forget-password', 'Resturant\AuthController@forgetPassword');
        Route::post('/reset-password', 'Resturant\AuthController@resetPassword');
        Route::post('/contact_us', 'Mobile\ProfileController@contact_us');
        // profiles
        Route::post('/profile/update', 'Resturant\ProfileController@update');
        Route::post('/change-password', 'Resturant\ProfileController@changePassword');
        Route::get('/user/statistics', 'Resturant\AuthController@analytics');
        Route::get('/balance', 'Resturant\ProfileController@balance');
        Route::get('/notifications', 'Resturant\ProfileController@notifications');
        Route::get('/notifications/{notification}', 'Resturant\ProfileController@notification_show');
        Route::get('/branches', 'Resturant\ProfileController@branches');
        Route::get('/address', 'Resturant\AddressController@index');
        Route::post('/address/create', 'Resturant\AddressController@store');
        Route::get('/order', 'Resturant\OrderController@index');
        Route::post('/order_details', 'Resturant\OrderController@details');

        Route::post('/order', 'Resturant\OrderController@store');
        Route::post('/order/update-order-status', 'Resturant\OrderController@updateOrderStatus');
        Route::post('/order/update-order-to-paid', 'Resturant\OrderController@updateOrderToPaid');
        Route::get('/search', 'Resturant\OrderController@search');
        Route::get('/Daily/orders', 'Resturant\OrderController@Daily');
        Route::get('/order_tracking', 'Resturant\OrderController@order_tracking');
        Route::post('/new_order', 'Resturant\OrderController@resturantOrder');
        Route::get('/Reports', 'Resturant\ReportsController@index');
        Route::get('/Reports/search', 'Resturant\ReportsController@search');
        Route::get('/Client_Delegate', 'Resturant\ReportsController@Client_Delegate');


    });

});


