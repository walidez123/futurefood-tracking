@extends('layouts.master')
@section('pageTitle', 'Order : #')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.view'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])
 <style>
  
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

        th, td {
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
 
text{
text-align:center ;
}
.invoice-col{
 width: 10cm;

font-size:9px
}
    .border{
        border:1px solid #000
    }
  
    </style>

   
    <div class="row no-print ">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i> @lang('app.print')</a>
            </div>
    </div>
   
   
 
    
      
          @if(!empty($orders) && count($orders) > 0)
        @foreach($orders as $order)
      
        <section class="invoice">
        <div class="container">
            <div class="row">
              <div class="col-xs-12 col-md-12 col-lg-12 invoice-col ">
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px;padding:5px">
                        <img src="{{ asset('storage/' . $order->user->company->logo) }}" class="img-responsive"  width="50"/>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 70px;padding:5px">
                        {!! QrCode::size(50)->generate($order->order_id); !!}
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 30px; padding:5px">
                        رقم الطلب : {{$order->order_id}} 
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 25px;padding:5px">
                         Sender Info
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 25px;padding:5px">
                          RECIVER INFO
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 90px;padding:5px">
                     @if($order->reference_number!=NULL)
                      @lang('admin_message.reference_number'): {{$order->reference_number}}
                         @endif
                       <br>
                       @lang('goods.store_name'): {{$order->user->store_name}}
                       <br>
                       @lang('order.phone'): {{ $order->user->phone }} <br>
                       @lang('order.address'):{{! empty($order->address) ? $order->address->address : ''}} <br>
                       

                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6 border" style="height: 90px;padding:5px">
                       @lang('order.customer_name') : {{$order->receved_name}}  <br>
                       @lang('order.phone') : {{ $order->receved_phone }}  <br>
                       @lang('admin_message.City') : {{! empty($order->recevedCity) ? $order->recevedCity->title : ''}}<br>
                       @lang('order.address') : {{$order->receved_address}}<br>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 30px; padding:5px;width:100%">
                        @lang('order.amount_delivery') : {{$order->amount}} 
                    </div>
                     <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: auto; padding:5px;width:100%">
                        <div class="col-xs-6 col-lg-6 col-md-6 ">  {{ __("admin_message.Tracking Number")}} :
                        <br> {{$order->tracking_id}} </div>
                        <div class="col-xs-6 col-lg-6 col-md-6 "> {!! QrCode::size(40)->generate(route("track.order",['tracking_id'=>$order->tracking_id])); !!}</div>
                    </div>
                    @if($order->order_contents!=NULL)
                    <div class="col-xs-12 col-md-12 col-lg-12 text-center border" style="height: 50px; padding:5px">
                        محتويات الطلب : {{$order->order_contents}} 
                    </div>
                    @endif


                   
             </div>
            </div>
        </div>
       
    </section>
        
       


     
  @endforeach
  @endif
  

</div><!-- /.content-wrapper -->
@endsection
