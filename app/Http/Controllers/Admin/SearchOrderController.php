<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\City;
Use App\Models\User;
Use App\Models\CompanyServiceProvider;


class SearchOrderController extends Controller
{
    public function index(request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $work_type = $request->work_type;
        if (($request->work_type == 1 && in_array('show_order', app('User_permission'))) ||
        $request->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
        $request->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
        $request->work_type == 4 && in_array('show_order_fulfillment', app('User_permission'))) {
        

        if ($work_type == 1) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 2) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 3) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 4) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

        }

        $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)->orderBy('id', 'desc')->get();

        // $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($work_type) {
        //     $query->where('work', $work_type);
        // })->orderBy('id', 'desc')->get();

        
        $cities = City::get();
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
        $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();  
        return view('admin.search_and_filter.search', compact( 'work_type', 'clients', 'statuses', 'delegates', 'cities', 'service_providers'));

        } else {
            return redirect(url(Auth()->user()->user_type));
        }
                

    }

    public function store(request $request)
    {
        {
            if ($request->exists('type')) {
                $from = $request->get('from');
                $to = $request->get('to');
                $user_id = $request->get('user_id');
                $status_id = $request->get('status_id');
                $delegate_id = $request->get('delegate_id');
                $contact_status = $request->get('contact_status');
                $paid = $request->get('paid');
                $sender_city = $request->get('sender_city');
                $receved_city = $request->get('receved_city');
                $search = $request->get('search');
                $search_order = $request->get('search_order');
                $service_provider_id = $request->get('service_provider_id');
                $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$request->work_type);
                
                if ($from != null && $to != null) {
                    if ($request->type == 'ship') {
    
                        $orders = $orders->whereDate('pickup_date', '>=', $from)
                            ->whereDate('pickup_date', '<=', $to);
    
                    } else {
                        $orders = $orders->whereDate('created_at', '>=', $from)
                            ->whereDate('created_at', '<=', $to);
                    }
                } else {
                    $orders = $orders->orderBy('pickup_date', 'DESC');
                }
                if ($sender_city != null) {
                    $orders->where('sender_city', $sender_city);
                }
    
                if ($receved_city != null) {
                    $orders->where('receved_city', $receved_city);
                }
                if ($user_id != null) {
                    $orders->where('user_id', $user_id);
                }
                if ($status_id != null) {
                    $orders->where('status_id', $status_id);
                }
                if ($contact_status != null) {
                    //call_count
                    if ($contact_status == 0) {
                        $orders->where('whatApp_count', 0)->where('call_count', 0);
                    } else {
                        $orders->where(function ($q) {
                            $q->where(function ($q1) {
                                $q1->where('whatApp_count', 0);
                                $q1->where('call_count', '>', 0);
                            })->orWhere(function ($q2) {
                                $q2->where('whatApp_count', '>', 0);
                                $q2->where('call_count', 0);
                            });
                        });
                    }
                }
                if ($paid != null) {
                    if ($paid == 0) {
                        $orders->where('amount_paid', 0);
                    } else {
                        $orders->where('amount_paid', 1);
                    }
                }
                if ($delegate_id != null) {
                    $orders->where('delegate_id', $delegate_id);
                }
                if ($service_provider_id != null) {
                    $orders->where('service_provider_id', $service_provider_id);
    
                }
                if (isset($search) && $search != '') {
                    $this->quickSearch($orders, $search)->get();
                }
    
                if (isset($search_order) && $search_order != '') {
    
                    $search_order_array = array_map('trim', array_filter(explode(' ', $search_order)));
    
                    $orders = $orders->where(function ($q) use ($search_order_array) {
                        $q->whereIn('order_id', $search_order_array);
                        $q->orWhereIn('id', $search_order_array);
                        $q->orWhereIn('reference_number', $search_order_array);
                    });
                }
                $orders=$orders->get();
    
    
            }
           else if ($request->status != null) {
                $orders = Order::where('company_id', Auth()->user()->company_id)->where('status_id',$request->status)->where('is_returned', 0)->where('work_type',$request->work_type)->get(); 
    
            }else{
                $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$request->work_type)->get(); 
    
    
            }
            return view('admin.search_and_filter.orders', compact('orders'));
        }
    }


    public function quickSearch($orders, $search)
        {
            $orders = $orders->where(function ($query) use ($search) {
                $query->where('order_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('tracking_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('pickup_date', 'LIKE', '%' . $search . '%')
                    ->orWhere('sender_notes', 'LIKE', '%' . $search . '%')
                    ->orWhere('number_count', 'LIKE', '%' . $search . '%')
                    ->orWhere('reference_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_email', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_address', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_address_2', 'LIKE', '%' . $search . '%')
                    ->orWhere('receved_notes', 'LIKE', '%' . $search . '%')
                    ->orWhere('order_contents', 'LIKE', '%' . $search . '%')
                    ->orWhere('amount', 'LIKE', '%' . $search . '%')
                    ->orWhere('call_count', 'LIKE', '%' . $search . '%')
                    ->orWhere('whatApp_count', 'LIKE', '%' . $search . '%')
                    ->orWhere('is_finished', 'LIKE', '%' . $search . '%')
                    ->orWhere('amount_paid', 'LIKE', '%' . $search . '%')
                    ->orWhere('order_weight', 'LIKE', '%' . $search . '%')
                    ->orWhere('over_weight_price', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('senderCity', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('status', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('recevedCity', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('store_name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('delegate', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
            return $orders;
        }


}