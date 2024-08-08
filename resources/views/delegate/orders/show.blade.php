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

    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif



      <div class="col-xs-6 printhidden" style="float:left">

        {{-- <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank">{{ __("admin_message.Send
          a message for evaluation") }} </a> --}}
       

      </div>
      <div class="col-xs-12 col-md-6 col-lg-6  text-center invoice-col">
        <h2 class="page-logo ">
          <img src="{{asset('storage/'.Auth()->user()->company->avatar)}}" />
        </h2>
      </div>

      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">

      <!-- /.col -->

      <div class="col-xs-12 col-md-12 col-lg-12  invoice-col">
        <div class="col-xs-12 col-md-3 col-lg-3 ">
          {!! QrCode::size(150)->generate($order->order_id); !!}
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
          <b>{{ __("admin_message.order status")}}:</b> {{! empty($order->status) ? $order->status->trans('title') : ''}} 

        </div>
      </div>

      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
            <th>@if($order->work_type==1){{ __("admin_message.Store Name")}} @else {{ __("admin_message.Restaurant Name")}} @endif</th>
            <th> {{! empty($order->user) ? $order->user->store_name : ''}}</th>

          </tr>
          @if($order->address!=NULL)
            <tr>
              <th>{{ __("admin_message.addressname")}}</th>
              <th>{{ $order->address->address }}</th>
            </tr>
          @endif
          <tr>
            <th>{{ __("admin_message.addressdescription")}}</th>
            <th>{{! empty($order->address) ? $order->address->description : ''}}</th>

          </tr>
          <tr>
          @if($order->address!=NULL)
            <tr>
              <th>{{ __("admin_message.Phone")}}</th>
              <th>{{!$order->address->phone }}  <a href="tel:{{$order->address->phone}}" style="padding:5px"><i class="fa fa-phone fa-1x"></i></a> <a href="https://api.whatsapp.com/send?phone={{$order->address->phone}}"  style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x" style="color:green"></i></a></th>
            </tr>
          @endif
          @if($order->address!=NULL)
            <tr>
              <th>{{ __("admin_message.location on map")}}</th>
              <th><a
                  href="https://www.google.com/maps/search/?api=1&query={{ $order->address->latitude }},{{ $order->address->longitude }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
            </tr>
          @endif
          @if($order->address!=NULL)
            <tr>
              <th>{{ __("admin_message.location on map")}}</th>
              <th><a
                  href="{{ $order->address->link }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
            </tr>
          @endif

          @if($order->delegate != NULL)

            <tr>
              <th>{{ __("admin_message.delegate")}}</th>
              <th> {{$order->delegate->name}}</th>
            </tr>
          @endif

          @if($order->work_type==1)

          <tr>
            <th>{{ __("admin_message.reference_number")}}</th>
            <th>{{$order->reference_number}}</th>
          </tr>
          <tr>
            <th>{{ __("admin_message.Order content")}}</th>
            <th>{{$order->order_contents}}</th>
          </tr>
          <tr>
            <th>{{ __("admin_message.number")}}</th>
            <th> {{$order->number_count}}</th>
          </tr>
          @else
          <tr>
            <th>{{ __("admin_message.Payment status")}}</th>
            <th> @if($order->amount_paid==0)
              {{ __("admin_message.UnPaid")}}
              @else
              {{ __("admin_message.Paid")}}
              @endif</th>
          </tr>
          <tr>
            <th>{{__("app.Payment amount upon receipt")}}</th>
            <th> {{$order->amount}}</th>

          </tr>
          @if($order->payment_method!=NULL)
          <tr>
            <th>{{__("app.Payment Method")}}</th>
            <th>
              @if($order->payment_method==1)
              {{__("app.cash")}}
              @elseif($order->payment_method==2)
              {{__("app.network")}}
              @elseif($order->payment_method==3)
              {{__("app.online")}}
              @endif
            </th>
          </tr>
          @endif




          @endif
        </table>
      </div>

      <!-- /.col -->
      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
            <th>{{ __("admin_message.Client name")}}</th>
            <th> {{$order->receved_name}}</th>

          </tr>
          <tr>
            <th>{{ __("admin_message.Phone")}}</th>
            <th>{{!$order->receved_phone}}  <a href="tel:{{$order->receved_phone}}" style="padding:5px"><i class="fa fa-phone fa-1x"></i></a> <a href="https://api.whatsapp.com/send?phone={{$order->receved_phone}}"  style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x" style="color:green"></i></a></th>
          </tr>
          @if(! empty($order->recevedCity))
          <tr>
            <th>{{ __("app.city")}}</th>
            <th>{{$order->recevedCity->trans('title') }}</th>

          </tr>
                    @if($order->region!=NULL)

          <tr>
            <th>{{ __("app.neighborhood")}}</th>
            <th>{{ $order->region->trans('title') }}</th>

          </tr>
          @endif
          @endif
          <tr>
            <th>{{ __("app.address")}}</th>
            <th>{{$order->receved_address}}</th>
          </tr>
          @if($order->latitude)
          <tr>
            <th>{{ __("admin_message.location on map")}}</th>
            <th><a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}"
                target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
          </tr>
          <tr>
          </tr>@endif

          </tr>
            <tr>
               <th>
               {{ __("admin_message.referencenumber")}}
               </th>
               <td>
               {{ $order->reference_number}}
               
               </td>
            </tr>
          @if($order->real_image_confirm!=NULL)
          <tr>
            <th>{{__("app.Picture of the order after delivery")}}</th>
            <th>
              <img src="{{asset('storage/'.$order->real_image_confirm)}}" />

            </th>
          </tr>
          @endif
        
        </table>
      </div>

      <!-- /.col -->
    </div>
      {{-- show order products --}}
  @if($order->product && count($order->product) > 0)
    <div class="row">
      <h3>{{__("app.order products")}}</h3>


      <table class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
            {{-- <th>#</th> --}}
          <th>{{__("app.product name")}}</th>
            <th>{{__("app.size")}}</th>
            <th>{{__("app.number")}}</th>
            
          </tr>
        </thead>
        <tbody>
          <?php $count = 1;
                $date = now()->format('Y-m-d');

            ?>
          @foreach ($order->product as $i=>$product)
            <tr>
              <th>{{$product->product_name}}</th>
              <th>{{$product->size}}</th>
              <th>{{$product->number}}</th>
               
                
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
        <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
          {{__("admin_message.Print")}}</a>
          @if($order->work_type==1 && Auth()->user()->company_setting->status_shop!=$order->status_id)

           @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
        <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
         
          {{__("app.Change_status")}} </button>
          @endif
          @elseif($order->work_type==2 && Auth()->user()->company_setting->status_res!=$order->status_id)
          @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
          <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
           {{__("app.Change_status")}} </button>
          @endif
          @elseif($order->work_type==4 )
          <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
           {{__("app.Change_status")}} </button>

          

          @endif
        <a class="btn btn-info pull-right printhidden"
          href="{{route('delegate-orders.index')}}"><i
            class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>
          

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
          <h4 class="modal-title"> @lang('app.Change_status')</h4>
        </div>
        <form action="{{route('delegate-orders.update', $order->id)}}" method="POST">
          <div class="modal-body">
          @csrf
                @method('PUT')
                            <div class="form-group">
            <select class="form-control" id="status_id" name="status_id" required>
                        <option value="">@lang('app.select')  @lang('app.status')</option>
                        @foreach ($statuses as $status)
                        <option value="{{$status->id}}" >{{$status->trans('title')}}</option>
                        @endforeach
            </select>              
            </div>
         
           
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