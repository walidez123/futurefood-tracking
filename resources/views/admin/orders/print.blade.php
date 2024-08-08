@extends('layouts.master')
@section('pageTitle', 'Order : #')
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', [
    'title' => __('app.order', ['attribute' => '']),
    'type' => __('app.view'),
    'iconClass' => 'fa-truck',
    'url' => route('orders.index'),
    'multiLang' => 'false',
    ])
    <style>
    .page {
        page-break-after: always;
    }
    .page-logo {
        width: 250px;
        height: 100px;
        display: none;
    }

    table {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 25px;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: right;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    span.h4 {
        float: right;
        height: 60px;
    }

    @media print {

        .page-header,
        .main-footer,
        .printhidden,
        #send-notification {
            display: none;
        }

        .page-logo {
            display: block;
        }

        table {
            width: 100%;
        }
    }

    text {
        text-align: center;
    }

    .invoice-col {
        width: 10cm;
        height: 15Cm;


        font-size: 12px
    }

    .border {
        border: 1px solid #000
    }
    </style>


    <div class="row no-print ">
        <div class="col-xs-2">
            <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
                @lang('app.print')</a>
        </div>
        <div class="col-xs-2">
                @foreach($orders as $i=>$order)

                <input type="hidden" id="order_id" class="order_id" name="order_ids[{{$i}}]" value="{{$order->id}}">
                @endforeach
                <button  id="download" class="btn btn-primary"><i class="fa fa-download"></i>
                @lang('app.download') PDF</button>
        </div>
    </div>


    @if(!empty($orders) && count($orders) > 0)
    @foreach($orders as $order)
        <div class="invoice">
            <!-- Your existing invoice content for a single order -->
            <div class="container">
                <div class="row page">
                    <div class="col-xs-12 col-md-12 col-lg-12 invoice-col">
                        <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px; padding: 5px; display: flex; align-items: center;">
                            <img src="{{ asset('storage/' . $order->user->company->logo) }}" class="img-responsive" width="100" style="margin-right: 10px;">
                            <span>عدد القطع: {{ $order->number_count }}</span>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px;padding:5px">
                            {!! QrCode::size(50)->generate($order->order_id) !!}
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center border" style="height: 30px; padding:5px">
                            order number : {{$order->order_id}}
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center border" style="height: 30px; padding:5px">
                            COD : {{ $order->amount }}
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 25px;padding:5px">
                            Sender Info
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 90px;padding:5px">
                            @if($order->reference_number!=NULL)
                            @lang('admin_message.reference_number'): {{$order->reference_number}}
                            @endif
                            <br>
                            @lang('goods.store_name'): {{$order->user->store_name}}
                            <br>
                            @lang('order.phone'): {{ $order->user->phone }} <br>
                            @lang('order.address'):{{! empty($order->address) ? $order->address->address : ''}} 
                            @if(! empty($order->address))
                            @if(! empty($order->address->city))
                            |{{$order->address->city->trans('title')}}
                            @endif
                            @endif
                            <br>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 25px;padding:5px">
                            RECIVER INFO
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 90px;padding:5px">
                            @lang('order.customer_name') : {{ $order->receved_name }} <br>
                            @lang('order.phone') : {{ $order->receved_phone }} <br>
                            @lang('admin_message.City') :
                            {{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}<br>
                            @lang('order.address') : {{ $order->receved_address }}<br>
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12 text-center border"style="height: auto; padding:5px;width:100%">

                            @if($order->service_provider)
                                @if($order->service_provider->id == 908 )
                                    @if ($order->tracking_code)

                                        <div class="col-xs-6 col-lg-6 col-md-6 "> 
                                            {{ __("admin_message.Tracking Number")}} :
                                            <br> {{$order->tracking_code }}
                                            <br>

                                        <div class="col-xs-6 col-lg-6 col-md-6 ">
                                            {!! DNS1D::getBarcodeHTML($order->tracking_code , 'C128') !!} <br>
                                        </div>
                                        @endif
                                    @endif
                                @else

                                    @if($order->consignmentNo) 
                                    <div class="col-xs-3 col-lg-3 col-md-3 "> 
                                    @else 
                                        <div class="col-xs-6 col-lg-6 col-md-6 "> 
                                    @endif 
                                        {{ __("admin_message.Tracking Number")}} :
                                        <br> {{$order->tracking_id}}
                                    </div>
                                    @if($order->consignmentNo) 
                                        <div class="col-xs-3 col-lg-3 col-md-3 "> 
                                    @else 
                                        <div class="col-xs-6 col-lg-6 col-md-6 "> 
                                    @endif 
                                    {!! QrCode::size(60)->generate(route("track.order",['tracking_id'=>$order->tracking_id])) !!}
                                    </div>
                                    @if($order->consignmentNo)
                                        <div class="col-xs-6 col-lg-6 col-md-6 ">
                                        {!! QrCode::size(90)->generate($order->consignmentNo) !!}
                                        </div>
                                    @endif

                                @endif 
                              

                           
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 70px; padding:5px">
                            @if ($order->user->work == 4)
                                @if($order->goods)
                                    @foreach($order->goods as $good)
                                        <div class="col-xs-6 col-lg-6 col-md-6 "> 
                                            {{ __("goods.skus")}} : {{$good->goods->SKUS}} ({{$good->number}}) pices <br>
                                        </div>
                                    @endforeach
                                @endif
                            @elseif($order->user->work == 1 && $order->product && count($order->product) > 0 && ($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name =='salla'))
                                @foreach ($order->product as $i=>$product)
                                    <div class="col-xs-6 col-lg-6 col-md-6 "> 
                                        {{ __("app.product")}} :
                                        @if($product->sku!=NULL)
                                            {{$product->sku}}
                                        @endif
                                        ({{$product->number}}) pices <br>
                                    </div>
                                @endforeach
                            @elseif($order->order_contents)
                                بيانات الطلب : <br> {{$order->order_contents}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
    @endif


</div><!-- /.content-wrapper -->

@endsection
@section('js')
<script>
        $(document).ready(function() {
            $('#download').click(function() {
                // Get the order IDs from the hidden input fields
                const orderIds = [];
                $('.order_id').each(function() {
                    orderIds.push($(this).val());
                });

                $.ajax({
                    url: '{{ route('client-orders.downloadMultiple') }}', // Your Laravel route
                    type: 'GET',
                    data: { order_ids: orderIds }, // Send array of order IDs
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(blob) {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'orders.pdf';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    },
                    error: function() {
                        console.error('Error downloading PDF');
                    }
                });
            });
        });

    </script>

@endsection

