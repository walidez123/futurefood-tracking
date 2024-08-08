@extends('layouts.master')
@section('pageTitle',__("admin_message.Order").' : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  {{-- @include('layouts._header-form', ['title' => __("admin_message.Order"), 'type' => __("admin_message.View"),
  'iconClass' => 'fa-truck', 'url' =>
  route('client-orders.index'), 'multiLang' => 'false']) --}}
  <!-- Main content -->
  <style>
    .page-logo {
      display: none;
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 25px
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: RIGHT;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    span.h4 {
      float: right;
      highet: 60px;
    }

    @media print {
      .page-header {
        display: none;
      }

      .page-logo {
        display: block;
      }

      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 25px
      }

      td,
      th {
        border: 1px solid #dddddd;
        text-align: RIGHT;
        padding: 8px;
      }

      tr:nth-child(even) {
        background-color: #dddddd;
      }

      span.h4 {
        float: right;
        highet: 60px;
      }


      @page {
        size: auto;
        /* auto is the initial value */
        margin: 0;
        /* this affects the margin in the printer settings */
      }

      .main-footer {
        display: none;
      }

      .printhidden {
        display: none;
      }

      #send-notification {
        display: none;
      }
    }
  </style>
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12 col-md-6 col-lg-6  text-center invoice-col">
        <h2 class="page-logo ">
        @if(Auth()->user()->company)
            <img src="{{asset('storage/'.Auth()->user()->company_setting->logo)}}" />
          @else
            <!-- <img src="{{asset('logo/defult_avatar.jpg')}}" /> -->
            <img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"><

          @endif
        </h2>
      </div>

      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">

      <!-- /.col -->

      <div class="col-xs-12 col-md-12 col-lg-12  invoice-col">
        <div class="col-xs-12 col-md-3 col-lg-3 ">
          {!! QrCode::size(150)->generate($order->order_id) !!}
        </div>
        <div class="col-xs-12 col-md-6">
            {{ __("admin_message.Order")}} #{{$order->order_id}}
        </div>
        <div class="col-xs-12 col-md-6">
           {{ __("admin_message.Tracking Number")}}:</b> {{$order->tracking_id}}
             <br>
          @if($order->work_type==1)
          <b>@lang('app.ship_date'):</b> {{$order->pickup_date}} 

          <b>@lang('app.weight'): {{$order->order_weight}}</b>
          @else
          <b>{{ __("admin_message.Shipping Date")}}:</b> {{ $order->created_at->format('d/m/Y') }} 

          @endif
          <br>
          <!-- <b>{{ __("admin_message.order status")}}:</b> {{! empty($order->clientstatus) ? $order->clientstatus->trans('title') : ''}} -->


        </div>
        <div class="col-xs-12 col-md-12 col-lg-12 ">
       
        </div>
      </div>



      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
            <th>@if($order->work_type==3){{ __("admin_message.Warehouse Name")}} @else {{ __("fulfillment.fulfillment_client_name")}} @endif</th>
            <th> {{! empty($order->user) ? $order->user->store_name : ''}}</th>

          </tr>
          <tr>
            <th>{{ __("admin_message.addressname")}}</th>
            <th>{{! empty($order->address) ? $order->address->address : ''}}</th>

          </tr>
          <tr>
            <th>{{ __("admin_message.addressdescription")}}</th>
            <th>{{! empty($order->address) ? $order->address->description : ''}}</th>

          </tr>
          <tr>
            <th>{{ __("admin_message.Phone")}}</th>
            <th>{{! empty($order->address) ? $order->address->phone : ''}}</th>

          </tr>
         
          @if($order->store_address_id)
          <tr>
            <th>{{ __("admin_message.location on map")}}</th>
            <th><a
                href="https://www.google.com/maps/search/?api=1&query={{ $order->address->latitude }},{{ $order->address->longitude }}"
                target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
          </tr>
          @endif

          @if($order->delegate != NULL)

            <tr>
              <th>{{ __("admin_message.delegate")}}</th>
              <th> {{$order->delegate->name}}</th>
            </tr>
          @endif


        
      




        </table>
      </div>

      <!-- /.col -->
      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
          <th>{{__('admin_message.Warehouse Branches')}}</th>
            <th>{{! empty($order->warehouse) ? $order->warehouse->trans('title') : ''}}</th>

          </tr>

          @if($order->warehouse->latitude)
            <tr>
              <th>{{ __("admin_message.location on map")}}</th>
              <th><a href="https://www.google.com/maps/search/?api=1&query={{ $order->warehouse->latitude }},{{ $order->warehouse->longitude }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
            </tr>
            <tr>
          </tr>@endif
          <th>{{__('admin_message.Storage types')}}</th>
            <th> {{ $order->storage_types==1 ? __('admin_message.pallet') : __('admin_message.Carton')}}</th>

          </tr>
          <tr>
          <th> {{__('admin_message.Sizes')}}</th>
            <th>   {{! empty($order->size) ? $order->size->trans('name') : ''}}</th>

          </tr>

          <tr>
          <th> {{__('admin_message.Delivery Service')}}</th>
            <th> {{ $order->delivery_service==1 ? __('admin_message.Yes') : __('admin_message.No')}}</th>


          </tr>


          
      
         

          </tr>
   
      
        
        </table>
      </div>

      <!-- /.col -->
    </div>
      {{-- show order products --}}
  @if($order->pickup_orders_good && count($order->pickup_orders_good) > 0)
    <div class="row">
      <h3>{{__('goods.Goods')}}</h3>


      <table class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
          <th>{{__('goods.Goods')}}</th>
            <th>@lang('admin_message.Expiration date')</th>
            <th>{{__("app.number")}}</th>
            
          </tr>
        </thead>
        <tbody>
          <?php $count = 1;
                $date = now()->format('Y-m-d');

            ?>
          @foreach ($order->pickup_orders_good as $i=>$good)
            <tr>
              <th>{{!empty( $good->good) ? $good->good->trans('title') : ''}}</th>
              <th>{{$good->expiration_date}}</th>
              <th>{{$good->number}}</th>
               
                
            </tr>
            @endforeach
        </tbody>
      </table>

    </div>
  @endif

    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-12">
        <!-- <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i> -->
          <!-- {{__("admin_message.Print")}}</a> -->
        <!-- <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
          <i class="fa fa-bell"></i>
          @lang('app.notifications', ['attribute' => __('app.send')])
 </button> -->
        <a class="btn btn-info pull-right printhidden"
          href="{{route('orders_pickup.index', $order->id)}}"><i
            class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>
        <!-- <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank"> {{ __("admin_message.Send a message for evaluation") }}</a> -->
      

      </div>

    </div>

  </section>
  <!-- /.content -->
  <div class="modal fade" id="send-notification">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">                    @lang('app.notifications', ['attribute' => __('app.send')])
 </h4>
        </div>
        <form action="{{route('notifications.store')}}" method="POST">
          <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="name">{{__("admin_message.Title")}}</label>
              <input type="text" class="form-control" name="title" placeholder="{{__('admin_message.Title')}}"
                required>
              @error('title')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="name">{{__("admin_message.Message")}}</label>
              <textarea rows="3" class="form-control" name="message" placeholder="{{__('admin_message.Message')}}"
                required></textarea>

            </div>
            <input type="hidden" name="notification_from" value="{{Auth()->user()->id}}">
            <input type="hidden" name="notification_to" value="{{$order->user_id}}">
            <input type="hidden" name="notification_type" value="order">
            <input type="hidden" name="notification_to_type" value="admin">
            <input type="hidden" name="order_id" value="{{$order->id}}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left"
              data-dismiss="modal">{{__("admin_message.close")}}</button>
            <button type="submit" class="btn btn-primary">{{__("admin_message.Send")}}</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  
</div>
</div><!-- /.content-wrapper -->
@endsection