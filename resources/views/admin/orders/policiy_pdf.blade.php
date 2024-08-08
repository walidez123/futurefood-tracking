<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="print" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link media="print" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <style>
          body {
            font-family: Arial, sans-serif;
            font-size: 22px

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

           

            text {
                text-align: center;
            }

            .invoice-col {
                width: 10cm;
                height: 15Cm;
                font-size: 12px
            }

            .border {
                border: 2px solid #000
            }
        </style>
    <title>بوليصة شحن</title>
</head>
<body dir="rtl">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <section class="invoice">
        <div class="container">
            <div class="row">
              
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px; padding: 5px;">
                        <img src="{{ asset('storage/' . $order->user->company_setting->logo) }}" class="img-responsive" width="100">
                        <span>عدد القطع: {{ $order->number_count }}</span>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px;padding:5px;float:left">
                    {!! QrCode::size(50)->generate($order->order_id) !!}

                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 30px; padding:5px">
                        order number : {{$order->order_id}}
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
                        @lang('order.address'):{{! empty($order->address) ? $order->address->address : ''}} <br>


                                </div>
                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 25px;padding:5px">
                                    RECIVER INFO
                                </div>

                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 90px;padding:5px">
                                    @lang('order.customer_name') : {{ $order->receved_name }} <br>
                                    @lang('order.phone') : {{ $order->receved_phone }} <br>
                                    @lang('admin_message.City') :
                                    {{ !empty($order->recevedCity) ? $order->recevedCity->title : '' }}<br>
                                    @lang('order.address') : {{ $order->receved_address }}<br>
                                </div>
                                <div class="col-xs-12 col-md-12 col-lg-12 text-center border"
                                    style="height: 30px; padding:5px;width:100%">
                                    @lang('order.amount_delivery') : {{ $order->amount }}
                                </div>
                                <div class="col-xs-12 col-md-12 col-lg-12 text-center border"
                                    style="height: auto; padding:5px;width:100%">

                        @if($order->consignmentNo) <div class="col-xs-3 col-lg-3 col-md-3 "> @else <div class="col-xs-6 col-lg-6 col-md-6 "> @endif {{ __("admin_message.Tracking Number")}} :
                            <br> {{$order->tracking_id}}
                        </div>
                        @if($order->consignmentNo) <div class="col-xs-3 col-lg-3 col-md-3 "> @else <div class="col-xs-6 col-lg-6 col-md-6 "> @endif 
                            <!-- {!! QrCode::size(40)->generate(route("track.order",['tracking_id'=>$order->tracking_id])); !!} -->
                            {!! QrCode::size(60)->generate(route("track.order",['tracking_id'=>$order->tracking_id])) !!}

                        </div>
                        @if($order->consignmentNo)
                            <div class="col-xs-3 col-lg-3 col-md-3 "> 3pl number :
                                <br> {{$order->consignmentNo}}
                                {!! QrCode::size(90)->generate($order->consignmentNo) !!}

                            </div>
                        @endif
                    </div>

                    <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 70px; padding:5px">                        
                        @if ( $order->user->work == 4)
                            @if($order->goods)
                                @foreach($order->goods as $good) 
                                <div class="col-xs-6 col-lg-6 col-md-6 "> {{ __("goods.skus")}} : {{$good->goods->SKUS}} ({{$good->number}}) pices  <br>
                                </div>
                                @endforeach
                             @endif
                           @elseif($order->user->work == 1 && $order->product && count($order->product) > 0 && ($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name =='salla')) 
                             @foreach ($order->product as $i=>$product)
                             <div class="col-xs-6 col-lg-6 col-md-6 "> {{ __("app.product")}} : {{$product->product_name}} ({{$product->number}}) pices  <br>
                            </div>
                             @endforeach
       
                        @elseif($order->order_contents)
                        بيانات الطلب :  <br> {{$order->order_contents}}
                        @endif
                    </div>
                </div>
           
        </div>

    </section>



</div><!-- /.content-wrapper -->
</body>
</html>