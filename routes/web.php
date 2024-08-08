<?php

use App\Services\Adaptors\LaBaih\LaBaih;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Good;
use App\Models\Order;
use niklasravnsborg\LaravelPdf\Facades\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('upload-customers-excel', [\App\Http\Controllers\ClientsMapController::class, 'upload']);
// Route::post('client-data-map', [\App\Http\Controllers\ClientsMapController::class, 'index'])->name('upload-excel');
Route::post('/admin/check-order-exists', [App\Http\Controllers\Admin\ScanOrderController::class, 'checkOrderExists']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::post('/route', [App\Http\Controllers\MapsController::class, 'getRoute'])->name('calculate.route');
Route::get('/add-locations', [App\Http\Controllers\MapsController::class, 'showMap']);



// https://api.blinkco.io/external/v1/future-ex/update
Route::webhooks('aymakan-webhook', 'aymakan');
Route::webhooks('blinkco-webhook', 'blinkco');
Route::webhooks('salla-webhook', 'salla');
Route::webhooks('foodics-webhook', 'foodics');
Route::webhooks('zid-webhook', 'zid');

Route::get('ordertest', function () {
    dd(gmdate('Y-m-d H:i:s', 1723890982));
    // $order=Order::findorfail(8360);

    // $pdf = PDF::loadView('website.show-as-pdf', ['order' => $order]);
    // $pdf->save(public_path('orders/test1'.'.pdf'));
    // // return redirect("https://future-ex.com/public/orders/test1.pdf");

    return view('website.show-as-pdf',compact('order'));


});


Route::get('order/print/{consignmentNo}', function ($consignmentNo) {
    LaBaih::print_order($consignmentNo);

});

Route::get('zid/redirect', [\App\Http\Controllers\ZidController::class, 'redirect']);
Route::get('zid/callback', [\App\Http\Controllers\ZidController::class, 'callback']);

Route::get('foodics-success', [\App\Http\Controllers\FoodicsController::class, 'redirect']);
Route::get(
    'foodics-new',
    [\App\Http\Controllers\FoodicsController::class, 'callback']
)->name('foodics-new');

Route::get('success-foodics', function () {
    return view('foodics-success');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Auth::routes();
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/send', 'App\Http\Controllers\Website\HomeController@send');
    Route::get('/', 'App\Http\Controllers\Website\HomeController@index')->name('home');
    Route::get('/send-request', 'App\Http\Controllers\Website\HomeController@feedback')->name('feedback.index');
    Route::post('/send-request', 'App\Http\Controllers\Website\HomeController@feedbackSubmit')->name('feedback.store');
    // Route::get('/about-us', 'App\Http\Controllers\Website\HomeController@about')->name('about');
    Route::get('/contact-us', 'App\Http\Controllers\Website\HomeController@contact')->name('contact');
    Route::post('/contact-us', 'App\Http\Controllers\Website\HomeController@contactSubmit')->name('contact.store');
    Route::get('/request-join', 'App\Http\Controllers\Website\RequestJoinController@requestJoin')->name('join');
    Route::post('/request-join', 'App\Http\Controllers\Website\RequestJoinController@requestJoinSubmit')->name('join.store');
    Route::get('/blog', 'App\Http\Controllers\Website\BlogController@index')->name('blog.index');
    Route::get('/blog/{post}', 'App\Http\Controllers\Website\BlogController@show')->name('blog.show');
    Route::get('/tracking', 'App\Http\Controllers\Website\HomeController@tracking');
    Route::get('/track', 'App\Http\Controllers\Website\HomeController@track')->name('track.order');
    Route::get('delegates/terms', 'App\Http\Controllers\Website\HomeController@termsDelegate');
    //
    Route::get('/subscribe', 'App\Http\Controllers\Website\SubscriptionController@showForm')->name('subscribe.form');
    Route::post('/subscribe', 'App\Http\Controllers\Website\SubscriptionController@store')->name('subscribe.store');
    //
    Route::get('/privacy_policy', 'App\Http\Controllers\Website\HomeController@privacy_policy')->name('privacy_policy');
    Route::get('/faqs', 'App\Http\Controllers\Website\HomeController@faqs')->name('faqs');

    //

    // Route::post('/track', 'App\Http\Controllers\Website\HomeController@track')->name('track.order');
    Route::get('/service', 'App\Http\Controllers\Website\HomeController@services')->name('service');

    Route::get('print-order', 'App\Http\Controllers\Website\HomeController@printOrder')->name('print.order');

    Route::get('/order/rate/{key}/{mobile}', 'App\Http\Controllers\Website\RateOrderController@rateOrder')->name('rate.order');
    Route::post('/order/rate/{key}/{mobile}', 'App\Http\Controllers\Website\RateOrderController@postRateOrder')->name('post-rate.order');
    Route::get('/order/rates', 'App\Http\Controllers\Website\RateOrderController@listRateOrder')->name('list-rate.order');

    Route::middleware(['auth', 'client'])->prefix('client')->group(function () {

        Route::get('/', 'App\Http\Controllers\Client\HomeController@index')->name('client.dashboard');
        Route::get('/terms', 'App\Http\Controllers\Client\TremsController@index')->name('terms.show');
        Route::post('/terms/agree', 'App\Http\Controllers\Client\TremsController@agree')->name('terms.agree');
        Route::resource('/damaged-goods-client', '\App\Http\Controllers\Client\DamagedGoodsController');


        Route::resource('/client-goods', 'App\Http\Controllers\Client\GoodController');
        Route::POST('client-goods/import_execl', '\App\Http\Controllers\Client\GoodController@import_execl')->name('client-goods.import_execl');
        Route::get('client-good/download_excel', '\App\Http\Controllers\Client\GoodController@download_execl')->name('client-good.download_execl');

        Route::get('/client-goods/Qrcode/{id}', '\App\Http\Controllers\Client\GoodController@Qrcode')->name('client-goods.Qrcode');
        Route::get('/client-goods/Barcode/{id}', '\App\Http\Controllers\Client\GoodController@Barcode')->name('client-goods.Barcode');
        Route::get('/client-goods/details/{id}', '\App\Http\Controllers\Client\GoodController@details')->name('client-goods.details');

        Route::resource('/QR-client', '\App\Http\Controllers\Client\QRController');
        Route::resource('/packages_goods_client', '\App\Http\Controllers\Client\Packages_goodsController');

        Route::resource('/client-packages', 'App\Http\Controllers\Client\PackagesController');

        Route::resource('/addresses', 'App\Http\Controllers\Client\AddressController');
        Route::resource('/orders', 'App\Http\Controllers\Client\OrderController');
        Route::resource('/return_orders', 'App\Http\Controllers\Client\ReturnOrderController');

        Route::get('/orders/delete_product/{id}', '\App\Http\Controllers\Client\OrderController@delete_product')->name('orders.delete_product');
        Route::get('/download_pdf',  '\App\Http\Controllers\Client\OrderController@downloadMultiplePDFs')->name('client.orders.downloadMultiple');

        // Route::get('/orders/{status}', 'App\Http\Controllers\Client\OrderController@index');
        Route::resource('/orderspickup', 'App\Http\Controllers\Client\orderspickupController');
        Route::resource('/orders_pickup', 'App\Http\Controllers\Client\orders_pickupController');

        Route::put('receipt_date', 'App\Http\Controllers\Client\orderspickupController@receipt_date')->name('orderspickup.receipt_date');

        Route::get('/orderclient/makeReturn/{order}', '\App\Http\Controllers\Client\OrderController@createReturnOrder')->name('orderclient.return');

        Route::post('/place_order_excel', 'App\Http\Controllers\Client\OrderController@placeـorder_excel_to_db');

        Route::get('/order/history/{order}', 'App\Http\Controllers\Client\OrderController@history')
            ->name('order.history');
        Route::post('/ordersRes/store', 'App\Http\Controllers\Client\OrderController@res_store');

        Route::post('/order-print-invoice', 'App\Http\Controllers\Client\OrderController@print_invoices')
            ->name('order.print-invoice');

        Route::get('/transactions', 'App\Http\Controllers\Client\HomeController@transactions')
            ->name('transactions.client');
        Route::get('/order-notifications/{key}', 'App\Http\Controllers\NotificationController@orderNotification')->name('client.order-notification');
        //التقارير اليومية
        Route::resource('/reportsClient', 'App\Http\Controllers\Client\ReportsController');
        Route::get('exportxlsx/', '\App\Http\Controllers\Client\ReportsController@export')->name('reportsClient.export');

        // الفواتير
        Route::resource('/invoiceClient', 'App\Http\Controllers\Client\InvoiceController');
        Route::get('/invoiceClient/invoice/{order}', '\App\Http\Controllers\Client\InvoiceController@invoice')
            ->name('invoiceClient.invoice');

        Route::get('generateClient/pdf/{id}', '\App\Http\Controllers\Client\InvoiceController@generate');
        Route::get('reportpdfClient/{id}', '\App\Http\Controllers\Client\InvoiceController@reportpdf');
        Route::resource('/Export_to_excel_client', '\App\Http\Controllers\Client\ExportController');


        //employees
        Route::resource('/employees', 'App\Http\Controllers\Client\EmployeeController');
        Route::resource('/roles', '\App\Http\Controllers\Client\RoleController');
        //
        Route::get('/packages_good/search-goods', '\App\Http\Controllers\Client\Packages_goodsController@searchProduct')->name('packages_good.product_search');
        Route::get('/packages_good/search-goods-client', '\App\Http\Controllers\Client\Packages_goodsController@clientSearch')->name('packages_good.client_Search');

    });
    Route::get('/notifications', '\App\Http\Controllers\NotificationController@index')->name('notifications.index');
    Route::POST('/notifications', '\App\Http\Controllers\NotificationController@store')->name('notifications.store');
    Route::get('/notifications/{notification}', '\App\Http\Controllers\NotificationController@show')->name('notifications.show');
    Route::put('/notifications/{notification}/unread', '\App\Http\Controllers\NotificationController@unread')->name('notifications.unread');
    //

    Route::middleware(['auth', 'delegate'])->prefix('delegate')->group(function () {
        Route::get('/', 'App\Http\Controllers\Delegate\HomeController@index')->name('delegate.dashboard');
        Route::resource('/delegate-orders', 'App\Http\Controllers\Delegate\OrderController');
        Route::get('/transactions', 'App\Http\Controllers\Delegate\HomeController@transactions')->name('transactions.delegate');
        Route::get('/order/comments/{id}', 'App\Http\Controllers\Delegate\CommentController@index')->name('myOrder.comments');
        Route::POST('/order/comment', 'App\Http\Controllers\Delegate\CommentController@store')->name('myComment.store');
        Route::resource('/DayReport', 'App\Http\Controllers\Delegate\DayReportController');
    });
});

Auth::routes(['register' => false]);

Route::get('/profile', '\App\Http\Controllers\ProfileController@edit')->name('profile.edit');
Route::put('/profile/{user}', '\App\Http\Controllers\ProfileController@update')->name('profile.update');
// ajax url  :)
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/getregions/{id}/{lang}', '\App\Http\Controllers\HomeController@getregions');
    Route::get('/getregionsZone/{id}/{lang}', '\App\Http\Controllers\HomeController@getregionsZone');
    Route::get('/getregionsZoneEdit/{id}/{zone}/{lang}', '\App\Http\Controllers\HomeController@getregionsZoneEdit');
    Route::get('/getclient/{id}', '\App\Http\Controllers\HomeController@getclient');
    Route::get('/getstatus/{id}/{lang}', '\App\Http\Controllers\HomeController@getstatus');
    Route::get('/clientAssign/{id}/{lang}', '\App\Http\Controllers\HomeController@clientAssign');
    Route::get('/Service_p/{id}/{lang}', '\App\Http\Controllers\HomeController@Service_p');

    Route::get('/getdelegate/{id}/{lang}', '\App\Http\Controllers\HomeController@getdelegate');
    Route::get('/getaddress/{id}/{lang}', '\App\Http\Controllers\HomeController@getaddress');
    Route::get('/getcontent/{tyoe}/{ware_id}', '\App\Http\Controllers\HomeController@getcontent');
    Route::get('/typedelegate_clients/{type}/{lang}', '\App\Http\Controllers\HomeController@type_delegate_clients');
    Route::get('/typedelegate_service_provider/{type}/{lang}', '\App\Http\Controllers\HomeController@typedelegate_service_provider');
    Route::get('/client_warehouse_packages/{client_id}/', '\App\Http\Controllers\HomeController@client_warehouse_packages');
    Route::get('/client_used_warehouse/{client_id}/', '\App\Http\Controllers\HomeController@client_used_warehouse');
    Route::get('/warhouse_packages/{warehouse_id}/', '\App\Http\Controllers\HomeController@warhouse_packages');
    Route::get('/autocomplete-good', '\App\Http\Controllers\HomeController@autocomplete_good');
    Route::get('/autocomplete-packages', '\App\Http\Controllers\HomeController@autocomplete_packages');
    Route::get('/ client_assign/address/{id}/{lang}', '\App\Http\Controllers\HomeController@client_assign_address');
    Route::get('/ client_goods_packages/{id}/{lang}', '\App\Http\Controllers\HomeController@client_goods');

});

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

        Route::get('/', '\App\Http\Controllers\Admin\HomeController@index')->name('admin.dashboard');
        Route::resource('/CityZone', '\App\Http\Controllers\Admin\CityZoneController');
        Route::resource('/RegionZone', '\App\Http\Controllers\Admin\RegionZoneController');
        // city company controller

        Route::resource('/CityCompany', '\App\Http\Controllers\Admin\CityController');
        Route::resource('/RegionCompany', '\App\Http\Controllers\Admin\RegionsController');
        Route::get('/regionsCompany/city/{id}', '\App\Http\Controllers\Admin\RegionsController@city')->name('regionsCompany.city');
        Route::get('/getregions/{id}', '\App\Http\Controllers\Admin\RegionsController@getregions');
        //end

        Route::resource('/DailyReport', '\App\Http\Controllers\Admin\DailyReportController');
        Route::get('exportxlsx/', '\App\Http\Controllers\Admin\DailyReportController@export')->name('DailyReport.export');
        Route::get('/setting/company', '\App\Http\Controllers\Admin\SettingController@setting')->name('settings.edit.company');
        Route::get('/setting/company/status', '\App\Http\Controllers\Admin\SettingController@status')->name('settings.edit.status');
        Route::get('/setting/company/warehouse', '\App\Http\Controllers\Admin\SettingController@warehouse')->name('settings.edit.warehouse');
        Route::get('/setting/company/terms', '\App\Http\Controllers\Admin\SettingController@terms')->name('settings.edit.terms');

        Route::put('/setting/update', '\App\Http\Controllers\Admin\SettingController@update')->name('settings.update.company');
        Route::resource('/statuses', '\App\Http\Controllers\Admin\StatusController');
        Route::get('/partners-status', '\App\Http\Controllers\Admin\StatusController@createFoodicsStatus')->name('foodics_statuses.show');
        Route::post('/foodics-status', '\App\Http\Controllers\Admin\StatusController@storeFoodicsStatuses')->name('foodics_statuses.store');
        Route::post('/partners-status', '\App\Http\Controllers\Admin\StatusController@storeProviderStatuses')->name('partners_statuses.store');
        Route::post('/blink-status', '\App\Http\Controllers\Admin\StatusController@storeBlinkStatuses')->name('blink_statuses.store');
        Route::post('/salla-status', '\App\Http\Controllers\Admin\StatusController@storeSallaStatuses')->name('salla_statuses.store');
        Route::post('/zid-status', '\App\Http\Controllers\Admin\StatusController@storeZidStatuses')->name('zid_statuses.store');
        Route::post('/aymakan-status', '\App\Http\Controllers\Admin\StatusController@storeAymakanStatuses')->name('aymakan_statuses.store');
        Route::resource('/rate_orders', '\App\Http\Controllers\Admin\RateOrderController');
        Route::post('/delegate_appear', '\App\Http\Controllers\Admin\StatusController@change_delegate_appear');
        Route::post('/client_appear', '\App\Http\Controllers\Admin\StatusController@change_client_appear');
        Route::post('/restaurant_appear', '\App\Http\Controllers\Admin\StatusController@change_restaurant_appear');
        Route::post('/shop_appear', '\App\Http\Controllers\Admin\StatusController@change_shop_appear');
        Route::post('/storehouse_appear', '\App\Http\Controllers\Admin\StatusController@change_storehouse_appear');
        Route::post('/fulfillment_appear', '\App\Http\Controllers\Admin\StatusController@change_fulfillment_appear');
        Route::post('/user_appear', '\App\Http\Controllers\Admin\StatusController@change_user_appear');

        Route::get('/clients/api', '\App\Http\Controllers\Admin\ClientController@api')
            ->name('clients.api');
        Route::POST('/clients/api', '\App\Http\Controllers\Admin\ClientController@apiStore')->name('clients-api.store');
        Route::DELETE('/clients/api/{id}', '\App\Http\Controllers\Admin\ClientController@apiDestroy')
            ->name('clients-api.destroy');
        Route::resource('/clients', '\App\Http\Controllers\Admin\ClientController');
        Route::resource('/clinet_packages', '\App\Http\Controllers\Admin\client_packagesController');
        Route::get('/clinet_packages/renewal/{id}', '\App\Http\Controllers\Admin\client_packagesController@renewal')->name('clinet_packages.renewal');


        Route::get('/clients/address/{id}', '\App\Http\Controllers\Admin\ClientController@addresses');
        Route::get('/clients/address_store/{id}', '\App\Http\Controllers\Admin\ClientController@address_create');
        Route::get('/clients/address_delete/{id}', '\App\Http\Controllers\Admin\ClientController@address_delete');
        Route::get('/clients/address_edit/{id}', '\App\Http\Controllers\Admin\ClientController@address_edit');
        Route::post('/clients/address_edit/{id}', '\App\Http\Controllers\Admin\ClientController@address_update');
        Route::post('/clients/address_store', '\App\Http\Controllers\Admin\ClientController@address_store');
        Route::get('/balances', '\App\Http\Controllers\Admin\ClientController@balances')
            ->name('client.balances');
        Route::get('/balances/transactions/{client}', '\App\Http\Controllers\Admin\ClientController@transactions')
            ->name('clients.transactions');
        Route::POST('/balances/transactions', '\App\Http\Controllers\Admin\ClientController@transactionStore')
            ->name('transaction.store');
        Route::delete('/balances/transactions/{transaction}', '\App\Http\Controllers\Admin\ClientController@transactionDestroy')
            ->name('transaction.destroy');
        Route::delete('/balances/pallet-subscriptions/{subscription}', '\App\Http\Controllers\Admin\ClientController@subscriptionDestroy')
            ->name('pallet-subscriptions.destroy');
        Route::get('/delegates/balances', '\App\Http\Controllers\Admin\DelegateController@balances')
            ->name('delegate.balances');
        Route::POST('/delegates/transactions', '\App\Http\Controllers\Admin\DelegateController@transactionStore')
            ->name('delegate.transaction.store');
        Route::delete('/delegates/transactions/{transaction}', '\App\Http\Controllers\Admin\DelegateController@transactionDestroy')
            ->name('delegate.transaction.destroy');
        Route::get('/delegates/tracking', '\App\Http\Controllers\Admin\DelegateController@tracking')
            ->name('delegates.tracking');
        Route::get('/tracking-map/{id}', 'App\Http\Controllers\Admin\DelegateController@livetracking');
        Route::get('delegates/tracking-map/', 'App\Http\Controllers\Admin\DelegateController@trackingdelegates');
        Route::get('/delegates/orders/{delegate}', '\App\Http\Controllers\Admin\DelegateController@orders')->name('delegates.orders');
        Route::get('/delegates/balances/transactions/{id}', '\App\Http\Controllers\Admin\DelegateController@transactions')
            ->name('delegates.transactions');
        Route::resource('/delegates', '\App\Http\Controllers\Admin\DelegateController');
        Route::get('/delegates/activation/{delegate}', '\App\Http\Controllers\Admin\DelegateController@activation')->name('delegates.activation');

        // Route::resource('/feedbacks', '\App\Http\Controllers\Admin\FeedbackController');
        Route::resource('/client-orders', '\App\Http\Controllers\Admin\OrderController');
        Route::get('/client-orders-import', '\App\Http\Controllers\Admin\OrderController@import')->name('client-orders.import');
        Route::get('/download_pdf',  '\App\Http\Controllers\Admin\OrderController@downloadMultiplePDFs')->name('client-orders.downloadMultiple');
        Route::resource('/filter-and-search', '\App\Http\Controllers\Admin\SearchOrderController');


        Route::resource('/Export_to_excel', '\App\Http\Controllers\Admin\ExportController');
        Route::resource('/Export_Reports_excel', '\App\Http\Controllers\Admin\ReportOrderController');
        Route::resource('/Export_Accounting_excel', '\App\Http\Controllers\Admin\ReportAccountingController');
        Route::resource('/orderDerlivaryReport', '\App\Http\Controllers\Admin\orderDerlivaryReportController');

        Route::get('/Export_Accounting_to_excel/cod', '\App\Http\Controllers\Admin\ReportAccountingController@cod')->name('Export_Accounting_excel.cod');

        Route::post('/client-orders/unassign_delegate/{order}', 'App\Http\Controllers\Admin\OrderController@unassignDelegate')->name('client-orders.unassign_delegate');

        // policy
        Route::post('/order-print-invoice', 'App\Http\Controllers\Admin\OrderController@print_invoices')
            ->name('order_client.print-invoice');

        Route::post('/pickup-order-print-invoice', 'App\Http\Controllers\Admin\orders_pickupController@print_invoices')
            ->name('pickup-order_client.print-invoice');
        //delete order product
        Route::get('/order-delete-product/{id}', 'App\Http\Controllers\Admin\OrderController@delete_product')
            ->name('orderclient.delete_product');
        //
        //
        Route::resource('/run_sheet', '\App\Http\Controllers\Admin\run_sheetController');

        //
        //run sheet
        Route::get('/order-run_sheet', 'App\Http\Controllers\Admin\OrderController@run_sheet')
            ->name('client-orders.run_sheet');
        Route::get('/order-scan', 'App\Http\Controllers\Admin\ScanOrderController@scan')->name('scan-orders.index');
        Route::post('/order-scan', 'App\Http\Controllers\Admin\ScanOrderController@scan')->name('scan-orders.scan');
        // scan-orders

        Route::post('/change-status', 'App\Http\Controllers\Admin\ScanOrderController@changeStatus');

        Route::put('/admin/orders/change_status/', '\App\Http\Controllers\ChangeOrderStatus@change_status')->name('admin.order.change_status');

        Route::DELETE('/otp/delete/{id}', '\App\Http\Controllers\Admin\OrderController@otp_delete')->name('otp.delete');
        Route::resource('/roles', '\App\Http\Controllers\Admin\RoleController');
        Route::resource('/users', '\App\Http\Controllers\Admin\UserController');
        Route::resource('/supervisor', '\App\Http\Controllers\Admin\SupervisorController');
        Route::get('/Service_provider/balances', '\App\Http\Controllers\Admin\Service_providerController@balances')->name('service_provideradmin.balances');
        Route::get('/Service_provider/balances/transaction/{id}', '\App\Http\Controllers\Admin\Service_providerController@transactions')->name('service_provider.transaction');
        Route::get('/client-orders/history/{order}', '\App\Http\Controllers\Admin\OrderController@history')
            ->name('client-orders.history');

        Route::post('/place_order_excel', 'App\Http\Controllers\Admin\OrderController@placeـorder_excel_to_db');

        Route::resource('/report', '\App\Http\Controllers\Admin\ReportController');
        Route::get('/report/invoice/{order}', '\App\Http\Controllers\Admin\ReportController@invoice')
            ->name('report.invoice');
        Route::get('generate/pdf/{id}', '\App\Http\Controllers\Admin\ReportController@generate');
        Route::get('reportpdf/{id}', '\App\Http\Controllers\Admin\ReportController@reportpdf');
        Route::get('/categories/confirm/{category}', '\App\Http\Controllers\Admin\CategoryController@confirm')
            ->name('categories.confirm');
        Route::Put('/orders/distribute', '\App\Http\Controllers\Admin\OrderController@distribute')
            ->name('order.distribute');
        //Assign to service provider
        Route::Put('/orders/assign/service_provider', '\App\Http\Controllers\Admin\OrderController@assign_to_service_provider')
            ->name('order.assign_to_service_provider');

        Route::get('/orders/type2/', '\App\Http\Controllers\Admin\OrderController@index2')->name('client-orders.index2');
        Route::put('/orders/change_status/', '\App\Http\Controllers\Admin\OrderController@change_status')->name('order.change_status_all');
        Route::get('/order-notifications/{key}', '\App\Http\Controllers\NotificationController@orderNotification')->name('notifications.order-notification');
        Route::get('/orders/makeReturn/{order}', '\App\Http\Controllers\Admin\OrderController@createReturnOrder')->name('order.return');
        Route::get('/orders/comments/{id}', '\App\Http\Controllers\Admin\CommentController@index')->name('comments.index');
        Route::POST('/orders/comment/', '\App\Http\Controllers\Admin\CommentController@store')->name('comments.store');
        Route::DELETE('/orders/comments/{id}', '\App\Http\Controllers\Admin\CommentController@destroy')->name('comments.destroy');

        Route::resource('/return-orders', '\App\Http\Controllers\Admin\ReturnOrderController');
        // for client
        Route::resource('/pickup-orders', '\App\Http\Controllers\Admin\PickupOrderController');
        Route::get('/fetch-client-goods/{clientId}', '\App\Http\Controllers\Admin\PickupOrderController@fetchClientGoods');

        // end
        // for warehouse and fulfillment
        Route::resource('/client_orders_pickup', '\App\Http\Controllers\Admin\orders_pickupController');
        Route::put('/pickup_order/change_status/', '\App\Http\Controllers\Admin\orders_pickupController@changeStatus')->name('pickup_order.change_status_all');
        Route::get('/client_orders_pickup_good/destory/{id}', '\App\Http\Controllers\Admin\orders_pickupController@destroy_good')->name('client_orders_pickup_good.destroy');
        Route::Put('/pickup_order/assign_delegate', '\App\Http\Controllers\Admin\orders_pickupController@assignDelegate')->name('pickup_order.assign_delegate');
        // end

        Route::resource('/Today-orders', '\App\Http\Controllers\Admin\TodayOrderController');

        Route::post('/pickuporders/distribute', '\App\Http\Controllers\Admin\PickupOrderController@distribute')
            ->name('pickuporders.distribute');

        // Assign order to delegate Rule
        Route::resource('/AssignOrdersRule', 'App\Http\Controllers\Admin\AssignOrdersRule');
        Route::resource('/Rule_service_provider', 'App\Http\Controllers\Admin\Rule_service_providerController');

        Route::delete('/delete_orders_rule_details/{id}', [App\Http\Controllers\Admin\AssignOrdersRule::class, 'delete_orders_rule_details'])->name('delete_orders_rule_details');
        Route::resource('/Company_branches', '\App\Http\Controllers\Admin\BranchController');
        Route::resource('/vehicles', '\App\Http\Controllers\Admin\VehicleController');

        // ware house
        Route::resource('/sizes', '\App\Http\Controllers\Admin\SizeController');
        Route::resource('/goods', '\App\Http\Controllers\Admin\GoodController');
        Route::POST('goods/import_execl', '\App\Http\Controllers\Admin\GoodController@import_execl')->name('goods.import_execl');
        Route::get('good/download_excel', '\App\Http\Controllers\Admin\GoodController@download_execl')->name('good.download_execl');

        Route::resource('/boxs', '\App\Http\Controllers\Admin\BoxController');

        Route::resource('/categories', '\App\Http\Controllers\Admin\CategoryController');
        Route::resource('/QR', '\App\Http\Controllers\Admin\QRController');
        Route::get('/generateQR', '\App\Http\Controllers\Admin\QRController@index2')->name('QR.index2');
        Route::post('/generateQR/store', '\App\Http\Controllers\Admin\QRController@store2')->name('QR.store2');

        Route::get('/goods/Qrcode/{id}', '\App\Http\Controllers\Admin\GoodController@Qrcode')->name('goods.Qrcode');
        Route::get('/goods/details/{id}', '\App\Http\Controllers\Admin\GoodController@details')->name('goods.details');

        // Route::post('/scan-code', 'Packages_goodsController@productScan');
        // Route::post('/scan-code-package', 'Packages_goodsController@packageScan');

        Route::resource('/warehouse_branches', '\App\Http\Controllers\Admin\Warehouse_branchesController');
        Route::get('/warehouse/search', '\App\Http\Controllers\Admin\Warehouse_branchesController@search')->name('warehouse_branches.search');
        Route::get('/warehouse/search_details', '\App\Http\Controllers\Admin\Warehouse_branchesController@search_details')->name('warehouse_branches.search_details');

        Route::resource('/warehouse_areas', '\App\Http\Controllers\Admin\warehouse_areasController');
        Route::resource('/warehouse_stand', '\App\Http\Controllers\Admin\Warehouse_standController');
        Route::resource('/warehouse_floor', '\App\Http\Controllers\Admin\warehouse_floorController');
        Route::resource('/warehouse_package', '\App\Http\Controllers\Admin\warehouse_packageController');
        Route::resource('/packages_goods', '\App\Http\Controllers\Admin\Packages_goodsController');
        Route::get('/packages_goods/scan/{id}', '\App\Http\Controllers\Admin\Packages_goodsController@scan')->name('packages_good.scan');
        Route::get('/packages_goods/scan_details/{id}', '\App\Http\Controllers\Admin\Packages_goodsController@scan_details')->name('packages_good.scan_details');

        Route::get('/packages_good/search-goods', '\App\Http\Controllers\Admin\Packages_goodsController@search')->name('packages_good.search');
        Route::get('/packages_good/search-goods-client', '\App\Http\Controllers\Admin\Packages_goodsController@clientSearch')->name('packages_good.clientSearch');

        Route::post('occupied_areas/', '\App\Http\Controllers\Admin\warehouse_areasController@area');
        Route::resource('/Packages', '\App\Http\Controllers\Admin\OfferController');
        Route::resource('/damaged-goods', '\App\Http\Controllers\Admin\DamagedGoodsController');

         //smb
    route::get('client-orders/printsmb/{order}','\App\Http\Controllers\Admin\OrderController@printsmb');
    route::get('client-orders/confirmSmb/{order}','\App\Http\Controllers\Admin\OrderController@confirmSmb');
    Route::resource('/confirmed-smb', '\App\Http\Controllers\Admin\ConfirmedSmbController');
    Route::put('/confirmed-smb/confirm', '\App\Http\Controllers\Admin\ConfirmedSmbController@update')->name('confirmed-smb.confirm');


        // end warehouse
    });
});

Route::middleware(['auth', 'supervisor'])->prefix('supervisor')->group(function () {
    Route::get('/', 'App\Http\Controllers\supervisor\HomeController@index')->name('supervisor.dashboard');
    Route::resource('/supervisororders', 'App\Http\Controllers\supervisor\OrderController');
    Route::get('/supervisororders/shipToday/{order}', '\App\Http\Controllers\supervisor\OrderController@shipToday')
        ->name('supervisororders.shipToday');
    Route::get('/supervisororders/history/{order}', '\App\Http\Controllers\supervisor\OrderController@history')
        ->name('supervisororders.history');
    Route::put('/orders/change_status/', '\App\Http\Controllers\ChangeOrderStatus@change_status')->name('order.change_status_supervisor');

    Route::put('/orders/change_status/', '\App\Http\Controllers\supervisor\OrderController@change_status')->name('supervisororders.change_status');
    Route::Put('/orders/distribute', '\App\Http\Controllers\supervisor\OrderController@distribute')
        ->name('supervisororders.distribute');
    Route::resource('/supervisor-delegates', '\App\Http\Controllers\supervisor\DelegateController');
    Route::get('/delegates/orders/{delegate}', '\App\Http\Controllers\supervisor\DelegateController@orders')->name('supervisor-delegates.orders');
    Route::get('/order/comments/{id}', 'App\Http\Controllers\supervisor\CommentController@index')->name('supervisororderscomments.index');
    Route::resource('/supervisor_DayReport', 'App\Http\Controllers\supervisor\DailyReportController');
});
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::middleware(['auth', 'service_provider'])->prefix('service_provider')->group(function () {

        Route::get('/', 'App\Http\Controllers\service_provider\HomeController@index')->name('service_provider.dashboard');
        Route::resource('/service_provider_orders', 'App\Http\Controllers\service_provider\OrderController');
        Route::get('/service_provider_orders/shipToday/{order}', '\App\Http\Controllers\service_provider\OrderController@shipToday')
            ->name('service_provider_orders.shipToday');
        Route::get('/supervisororders/history/{order}', '\App\Http\Controllers\service_provider\OrderController@history')
            ->name('service_provider_orders.history');

        Route::post('/service_provider_orders-print-invoice', 'App\Http\Controllers\service_provider\OrderController@print_invoices')
            ->name('service_provider_orders.print-invoice');

        // Route::post('/orders/change_status/', '\App\Http\Controllers\ChangeOrderStatus@change_status')->name('order.change_status_service_provider');

        Route::put('/orders/change_status/', '\App\Http\Controllers\service_provider\OrderController@change_status')->name('service_provider_orders.change_status');
        Route::Put('/orders/distribute', '\App\Http\Controllers\service_provider\OrderController@distribute')
            ->name('service_provider_orders.distribute');
        Route::resource('s_p_delegates', '\App\Http\Controllers\service_provider\DelegateController');
        Route::get('/delegates/orders/{delegate}', '\App\Http\Controllers\service_provider\DelegateController@orders')->name('s_p_delegates.orders');
        Route::get('/order/comments/{id}', 'App\Http\Controllers\service_provider\CommentController@index')->name('service_provider_orderscomments.index');
        Route::resource('/service_provider_DayReport', 'App\Http\Controllers\service_provider\DailyReportController');
        Route::get('/transactions', 'App\Http\Controllers\service_provider\HomeController@transactions')->name('transactions.service_provider');
        Route::get('/transactions/delegate', 'App\Http\Controllers\service_provider\HomeController@transactions_delegate')->name('transactions.service_provider_delegate');
        Route::get('/transactions/delegate/details/{id}', 'App\Http\Controllers\service_provider\HomeController@transactions_delegate_details')->name('transactions.transactions_delegate_details');
        Route::resource('/order_rule_provider', 'App\Http\Controllers\service_provider\AssignOrdersRule');

        Route::resource('/s_p_vehicles', 'App\Http\Controllers\service_provider\VehicleController');

        Route::delete('/delete_orders_rule_details/{id}', [App\Http\Controllers\service_provider\AssignOrdersRule::class, 'delete_orders_rule_details'])->name('service_provider.delete_orders_rule_details');
    });
});
Route::middleware(['auth', 'super_admin'])->prefix('super_admin')->group(function () {

    Route::get('/', 'App\Http\Controllers\super_admin\HomeController@index')->name('super_admin.dashboard');
    Route::resource('/defult_status', '\App\Http\Controllers\super_admin\StatusController');
    Route::resource('/company_providers', '\App\Http\Controllers\super_admin\Company_providerController');
    Route::resource('/search_order', '\App\Http\Controllers\super_admin\SearchOrderController');
    Route::resource('/service_provider', '\App\Http\Controllers\super_admin\Service_providerController');
    Route::get('companies/service-provider/activate/{id}', 'App\Http\Controllers\super_admin\Service_providerController@companyServiceProvider')->name('Service_provider.activate');
    Route::post('companies/service-provider/authtoken/{id}', 'App\Http\Controllers\super_admin\Service_providerController@saveAuthToken')->name('Service_provider.save_authtoken');
    Route::get('/service-provider/activate', '\App\Http\Controllers\super_admin\Service_providerController@activateServiceProvider');
    Route::get('/service-provider/deactivate', '\App\Http\Controllers\super_admin\Service_providerController@deactivateServiceProvider');
    Route::get('/service-provider/deactivate', '\App\Http\Controllers\super_admin\Service_providerController@deactivateServiceProvider');
    Route::resource('/provinces', '\App\Http\Controllers\super_admin\ProvinceController');
    Route::post('/defult_client_appear', '\App\Http\Controllers\super_admin\StatusController@change_client_appear');
    Route::post('/defult_restaurant_appear', '\App\Http\Controllers\super_admin\StatusController@change_restaurant_appear');
    Route::post('/defult_shop_appear', '\App\Http\Controllers\super_admin\StatusController@change_shop_appear');
    Route::post('/defult_storehouse_appear', '\App\Http\Controllers\super_admin\StatusController@change_storehouse_appear');
    //
    Route::resource('/companies', '\App\Http\Controllers\super_admin\companiesController');
    // companies.balances
    Route::get('/balances', '\App\Http\Controllers\super_admin\companiesController@balances')
        ->name('companies.balances');
    Route::get('/balances/transactions/{client}', '\App\Http\Controllers\super_admin\companiesController@transactions')
        ->name('companies.transactions');
    Route::POST('/balances/transactions', '\App\Http\Controllers\super_admin\companiesController@transactionStore')
        ->name('companies.transaction.store');
    Route::delete('/balances/transactions/{transaction}', '\App\Http\Controllers\super_admin\companiesController@transactionDestroy')
        ->name('companies.transaction.destroy');
    Route::get('/company/orders/{id}', '\App\Http\Controllers\super_admin\companiesController@orders')->name('company.orders');
    Route::resource('/delegate_request_join', '\App\Http\Controllers\super_admin\Delegate_request_joinController');
    Route::resource('/request_join_service_provider', '\App\Http\Controllers\super_admin\Service_provider_request_joinController');
    Route::resource('/sliders', '\App\Http\Controllers\super_admin\SliderController');
    Route::resource('/services', '\App\Http\Controllers\super_admin\ServiceController');
    Route::resource('/solutions', '\App\Http\Controllers\super_admin\SolutionsController');
    Route::resource('/partner-categories', '\App\Http\Controllers\super_admin\PartnerCategortyController');
    Route::resource('/what-we-do', '\App\Http\Controllers\super_admin\WhatWeDoController');
    Route::resource('/posts', '\App\Http\Controllers\super_admin\PostController');
    Route::resource('/pages', '\App\Http\Controllers\super_admin\PageController');
    Route::get('/transfer-clients', '\App\Http\Controllers\super_admin\TransferClientsController@transferClients')->name('transfer-clients');
    Route::post('/transfer-clients-store', '\App\Http\Controllers\super_admin\TransferClientsController@store')->name('transfer-clients.store');
    Route::resource('/contacts', '\App\Http\Controllers\super_admin\ContactController');
    Route::resource('/request-joins', '\App\Http\Controllers\super_admin\RequestJoinController');
    Route::resource('/notificationFCM', '\App\Http\Controllers\super_admin\notificationFCMController');
    Route::resource('/partners', '\App\Http\Controllers\super_admin\PartnerController');
    Route::resource('/testimoinals', '\App\Http\Controllers\super_admin\TestimoinalController');
    Route::resource('/faqs', '\App\Http\Controllers\super_admin\FaqController');
    Route::resource('/counters', '\App\Http\Controllers\super_admin\counterController');
    Route::resource('/subscription', '\App\Http\Controllers\super_admin\SubscriptionController');

    Route::resource('/cities', '\App\Http\Controllers\super_admin\CityController');
    Route::resource('/neighborhoods', '\App\Http\Controllers\super_admin\NeighborhoodController');
    Route::get('/neighborhoods/city/{id}', '\App\Http\Controllers\super_admin\NeighborhoodController@city')->name('neighborhoods.city');
    Route::get('/getneighborhoods/{id}', '\App\Http\Controllers\super_admin\NeighborhoodController@getneighborhoods');

    Route::get('/company/setting/{id}', '\App\Http\Controllers\super_admin\companiesController@setting')->name('company.setting');
    Route::post('/company/setting', '\App\Http\Controllers\super_admin\companiesController@setting_store')->name('companies.setting.store');
    Route::post('/company/setting/edit', '\App\Http\Controllers\super_admin\companiesController@setting_edit')->name('companies.setting.edit');

    // Route::resource('/feedbacks', '\App\Http\Controllers\super_admin\FeedbackController');
    Route::get('/settings', '\App\Http\Controllers\super_admin\WebSettingController@edit')
        ->name('settings.edit');
    Route::Put('/settings/update', '\App\Http\Controllers\super_admin\WebSettingController@update')
        ->name('settings.update');
    Route::get('/app/settings', '\App\Http\Controllers\super_admin\SettingController@edit')
        ->name('appSettings.edit');
    Route::Put('/app/settings/update', '\App\Http\Controllers\super_admin\SettingController@update')
        ->name('appSettings.update');
    //repoets
    Route::get('/monthly-reports', '\App\Http\Controllers\super_admin\ReportController@index')->name('monthly-reports.index');
    Route::get('/monthly-reports/{company}', '\App\Http\Controllers\super_admin\ReportController@show')->name('monthly-reports.show');
});
