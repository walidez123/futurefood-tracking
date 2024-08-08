@extends('layouts.master')
@section('pageTitle', __('admin_message.Dashboard'))
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">

            @if (in_array(1, $user_type) && in_array('show_order', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ count($ordersTodayShop) }}</h3>
                        <p>{{ __("admin_message.Today's Orders for Customers") }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <a href="{{ route('Today-orders.index', ['work_type' => 1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(4, $user_type) && in_array('show_order_fulfillment', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#15a308!important;color:#fff">
                    <div class="inner">
                        <h3>{{ count($ordersTodayFulfillment) }}</h3>
                        <p>{{ __("admin_message.Today's Orders for Fulfillment") }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <a href="{{ route('Today-orders.index', ['work_type' => 4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(2, $user_type) && in_array('show_order_res', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ count($ordersTodayRes) }}</h3>
                        <p>{{ __("admin_message.Today's Orders for Restaurants") }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('Today-orders.index', ['work_type' => 2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif

            @if (in_array(1, $user_type) && in_array('show_order', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\Order::where('work_type', 1)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Customer Orders') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <a href="{{ route('client-orders.index', ['work_type' => 1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(2, $user_type) && in_array('show_order_res', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\Order::where('work_type', 2)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Customer restaurant') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('client-orders.index', ['work_type' => 2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif

            @if (in_array(4, $user_type) && in_array('show_order_fulfillment', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#15a308!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\Order::where('work_type', 4)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Fulfilmant orders') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <a href="{{ route('client-orders.index', ['work_type' => 4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif

            @if (in_array(1, $user_type) && in_array('show_delegate', $permissionsTitle) )
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query){
                               $query->where('work', 1);
                               })->orderBy('id', 'desc')->count() }}
                        </h3>
                        <p>{{ __('admin_message.Customer Representatives') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <a href="{{ route('delegates.index', ['type' => 1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(2, $user_type) && in_array('show_delegate', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query){
                               $query->where('work', 2);
                               })->orderBy('id', 'desc')->count() }}
                        </h3>
                        <p>{{ __('admin_message.Restaurant Representatives') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <a href="{{ route('delegates.index', ['type' => 2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(4, $user_type) && in_array('show_delegate', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#15a308!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query){
                               $query->where('work', 4);
                               })->orderBy('id', 'desc')->count() }}
                        </h3>
                        <p>{{ __('admin_message.fulfillment delegates') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <a href="{{ route('delegates.index', ['type' => 4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif




            <!-- ./col -->

            <!-- ./col -->
            @if (in_array(1, $user_type) && in_array('show_client', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('user_type', 'client')->where('work', 1)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Number of Customers') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <a href="{{ route('clients.index', ['type' => 1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (in_array(2, $user_type) && in_array('show_resturant', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('user_type', 'client')->where('work', 2)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Number of Restaurant') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('clients.index', ['type' => 2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif

            @if (in_array(3, $user_type) )
            @if(in_array('show_client_warehouse', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#dc3545!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('user_type', 'client')->where('work', 3)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Number of warehouse') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('clients.index', ['type' => 3]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if(in_array('show_client_packages', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#28a745!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\Package::where('company_id', Auth::user()->id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Number of packages') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('warehouse_package.index', ['type' => 3]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @endif
            @if (in_array(4, $user_type) && in_array('show_client_fulfillment', $permissionsTitle))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#dc3545!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('user_type', 'client')->where('work', 4)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Number of Fulfmillent') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <a href="{{ route('clients.index', ['type' => 4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#15a308!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\Package::where('company_id', Auth::user()->id)->count() }}
                        </h3>
                        <p>{{ __('fulfillment.fulfillment number of packages') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <a href="{{ route('Packages.index', ['type' => 4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> -->
            @endif

        </div>
        <div class="row">
            <!-- pie chart -->
            <div class="col-xs-4" style="background: #fff;">
                @if($ordersPieChart->contains('total', '>', 0))

                <canvas style="margin-bottom:30px" height="100px" id="myChartPie"></canvas>
                @else
                <canvas style="margin-bottom:30px" height="100px" id="myChartPie"></canvas>

                <p>{{__('admin_message.No orders to display')}}.</p>



                @endif


            </div>
            <!-- end chart -->


            <div class="col-xs-8" style="background: #fff;">

                <ul class="nav nav-tabs" style="
    background: #fff;
    font-weight: bold;
    margin: 15px;
    margin-bottom: 3px;">
                    <li><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu1">{{ __('admin_message.today') }}</a></li>
                    <li class="active"><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu2">{{ __('admin_message.all') }}</a></li>
                    <li><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu3">{{ __('admin_message.yesterday') }}</a></li>
                    <li><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu4">{{ __('admin_message.Last 30 days') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in ">
                        <canvas id="myChartToday" style="margin-bottom:30px" height="100px"></canvas>
                    </div>
                    <div id="menu2" class="tab-pane fade in active">
                        <canvas id="myChart" style="margin-bottom:30px" height="100%"></canvas>
                    </div>
                    <div id="menu3" class="tab-pane fade in">
                        <canvas id="myChartyesterday" style="margin-bottom:30px" height="100px"></canvas>
                    </div>
                    <div id="menu4" class="tab-pane fade in">
                        <canvas id="myChartMonth" style="margin-bottom:30px" height="100px"></canvas>


                    </div>
                </div>

                <div>
                </div>
    </section>
    <!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
// Define global variables here
var labels = {!!Js::from($statuesChart) !!};
var orders = {!!Js::from($ordersChart) !!};
var ordersToday = {!!Js::from($orderChartToday) !!};
var ordersYesterday = {!!Js::from($orderChartYestrday) !!}; // Make sure to correct the variable name typo
var ordersMonth = {!!Js::from($orderChartMonth) !!};
// pie chart 
var ordersPieChart = {!!Js::from($ordersPieChart) !!};


var translations = {
    requests: "{{ __('admin_message.Requests') }}",
    UnPaid: "{{ __('admin_message.UnPaid') }}",
    Paid: "{{ __('admin_message.Paid') }}"

};
</script>
<script src="{{ asset('assets_web/js/charts.js') }}"></script>

@endsection