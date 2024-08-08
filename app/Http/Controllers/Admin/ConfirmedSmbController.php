<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusUpdated;
use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Jobs\ImportOrdersFromExcelAdmin;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Client_packages_good;
use App\Models\Good;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderProduct;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use App\Models\CompanyServiceProvider;
use GuzzleHttp\Exception\RequestException;
use App\Services\Adaptors\SmbExpress\SmbExpress;
use App\Services\Adaptors\Aymakan\Aymakan;
use App\Services\Adaptors\Farm\Farm;
use App\Services\Adaptors\LaBaih\LaBaih;
use App\Services\OrderAssignmentService;
use App\Traits\PushNotificationsTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Company_setting_status;
use Illuminate\Support\Facades\Log;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use App\Models\Packages_history;
use App\Models\Smb_city;


// use PDF;

class ConfirmedSmbController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
       
    }

    public function index(Request $request)
    {

        $perPage = 50; 
        $page = request()->has('page') ? request()->query('page') : 1; 
        if (
        ( in_array('show_order', app('User_permission'))) ||
        in_array('show_order_res', app('User_permission')) ||
        in_array('show_order_warehouse', app('User_permission')) ||
        in_array('show_order_fulfillment', app('User_permission')) ) 
        {

            
            //
            $user = Auth()->user();
            $orders = Order::where('service_provider_id', 908)->where('tracking_url',null)->where('public_pdf_label_url',null)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate(50);
            return view('admin.orders.smbconfirmed', compact('orders'));
            
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }


    public function update(request $request){
        $request['order_id'] = explode(',', $request['order_id'][0]);

        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
        ]);
        $orders = count($request['order_id']);

        for ($i = 0; $i < $orders; $i++) {

            $id = $request->order_id[$i];
            $order = Order::findOrFail($id);
                      //
            if ($order->service_provider_id != null) {
                if ($order->service_provider->id == '908') {
                    $this->confirmSmb($order->consignmentNo);
                }
            }
        }

        return back()->with('success', trans('admin_message.order_status_change_success'));

    }
    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    private function confirmSmb($id){
        $response = SmbExpress::confirmOrder($id);
        $data = json_decode($response->getBody(), true); // Parse response content as JSON
        $order=Order::where('consignmentNo',$id)->first();


        if ($response->getStatusCode() == 200) {
            $order->update([
                'tracking_url' => $data['data']['tracking_url'],
                'public_pdf_label_url' => $data['data']['public_pdf_label_url'],
                'tracking_code' => $data['data']['tracking_code'],


            ]);
        } 

        return redirect()->back()->with('success',trans('admin_message.the order is confirmed success'));

    }

    

  

    
}
