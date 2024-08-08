@extends('layouts.master')
@section('pageTitle', __('admin_message.Dashboard') )
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('admin_message.Dashboard') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('admin_message.Main') }}</a></li>
            <li class="active">{{ __('admin_message.Dashboard') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            @if(in_array(2,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ $ordersrestaurant > 0 ? $ordersrestaurant : 0 }}</h3>
                        <p>{{ __('admin_message.Customer restaurant') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('service_provider_orders.index',['work_type'=>2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if(in_array(1,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ $ordersCustomer > 0 ? $ordersCustomer : 0 }}</h3>
                        <p>{{ __('admin_message.Customer Orders') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <a href="{{ route('service_provider_orders.index',['work_type'=>1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            <!-- Fulfement  -->
            @if(in_array(4,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-red" style="background:#dc3545!important;color:#fff">
                    <div class="inner">
                        <h3>{{ $ordersFulfement > 0 ? $ordersFulfement : 0 }}</h3>
                        <p>{{ __('fulfillment.fulfillment orders') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <a href="{{ route('service_provider_orders.index',['work_type'=>4]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif




            <!--  -->
            @if(in_array(2,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::whereIn('id', $Arraydelegates)->where('work', 2)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Restaurant Representatives') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <a href="{{ route('s_p_delegates.index', ['type' => 2]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if(in_array(1,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('id', $Arraydelegates)->where('work', 1)->where('company_id', auth()->user()->company_id)->count() }}
                        </h3>
                        <p>{{ __('admin_message.Customer Representatives') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <a href="{{ route('s_p_delegates.index', ['type' => 1]) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if(in_array(1,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#17a2b8!important;color:#fff">
                    <div class="inner">
                        <h3>{{count($ordersTodayres)}}
                        </h3>
                        <p>{{ __('app.Number of daily orders customers') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <a href="{{ route('service_provider_orders.shipToday', 1) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if(in_array(2,$works))

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background:#ffc107!important;color:#fff">
                    <div class="inner">
                        <h3>{{count($ordersTodayRestaurant)}}</h3>
                        <p>{{ __('app.Number of daily orders restaurants') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <a href="{{ route('service_provider_orders.shipToday', 1) }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            <!--  -->
            @if(in_array(4,$works))

<div class="col-lg-3 col-6">
    <div class="small-box bg-info" style="background:#dc3545!important;color:#fff">
        <div class="inner">
            <h3>{{count($ordersTodayFulfement)}}
            </h3>
            <p>{{ __('fulfillment.Number of daily orders fulfillment') }}</p>
        </div>
        <div class="icon">
            <i class="fa-solid fa-car"></i>
        </div>
        <a href="{{ route('service_provider_orders.shipToday', 4) }}"
            class="small-box-footer">{{ __('admin_message.More Information') }}<i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
@endif




            <!--  -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{($balance == null) ? '0' : $balance}}</h3>
                        <p>{{ __('app.Balance') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-money-bill"></i>
                    </div>
                    <a href="{{ route('transactions.service_provider') }}"
                        class="small-box-footer">{{ __('admin_message.More Information') }}<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


        </div>

        <div class="col-xs-12" style="background: #fff;">

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
    </section>
    <!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- All orders -->
<script type="text/javascript">
var labels = {{Js::from($statuesChart)}};
var orders = {{Js::from($ordersChart)}};
const data = {
    labels: labels,
    datasets: [{
        label: '{{ __("admin_message.Requests") }}',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: orders,
    }]
};

const config = {
    type: 'line',
    data: data,
    options: {}
};
const myChart = new Chart(
    document.getElementById('myChart'),
    config
);
</script>
<!-- Today -->
<script type="text/javascript">
var labels = {{Js::from($statuesChart)}};
var ordersToday = {{Js::from($orderChartToday)}};
const dataToday = {
    labels: labels,
    datasets: [{
        label: '{{ __("admin_message.Requests") }}',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: ordersToday,
    }]
};

const configToday = {
    type: 'line',
    data: dataToday,
    options: {

    }
};
const myChartToday = new Chart(
    document.getElementById('myChartToday'),
    configToday
);
</script>
<!-- myChartyesterday -->
<script type="text/javascript">
var labels = {{Js::from($statuesChart)}};
var ordersyesterday = {{Js::from($orderChartYestrday)}};
const datayesterday = {
    labels: labels,
    datasets: [{
        label: '{{ __("admin_message.Requests") }}',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: ordersyesterday,
    }]
};

const configyesterday = {
    type: 'line',
    data: datayesterday,
    options: {}
};
const myChartyesterday = new Chart(
    document.getElementById('myChartyesterday'),
    configyesterday
);
</script>
<!-- Chart Month -->
<script type="text/javascript">
var labels = {{ Js::from($statuesChart) }};
var ordersMonth = {{Js::from($orderChartMonth)}};
const dataMonth = {
    labels: labels,
    datasets: [{
        label: '{{ __("admin_message.Requests") }}',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: ordersMonth,
    }]
};

const configMonth = {
    type: 'line',
    data: dataMonth,
    options: {}
};
const myChartMonth = new Chart(
    document.getElementById('myChartMonth'),
    configMonth
);
</script>

@endsection