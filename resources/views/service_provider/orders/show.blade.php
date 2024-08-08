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
  route('service_provider_orders.index'), 'multiLang' => 'false']) --}}
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



      <div class="col-xs-6 printhidden" style="float:left">

        {{-- <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank">{{ __("admin_message.Send
          a message for evaluation") }} </a> --}}
        @if($order->work_type==1)
        @if(Auth()->user()->company_setting!=null &&
        Auth()->user()->company_setting->status_can_return_shop==$order->status_id)


        @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();

        @endphp

        <!-- @if($order->is_returned==0 & $count==0)
        <a class="btn btn-primary" href="{{ route('order.return',['order' => $order]) }}" target="_blank">{{
          __("admin_message.Create a request return")}}</a>
        @endif -->
        @endif
        @else
        @if(Auth()->user()->company_setting!=null &&
        Auth()->user()->company_setting->status_can_return_res==$order->status_id)
        @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();

        @endphp

        <!-- @if($order->is_returned==0 & $count==0)
        <a class="btn btn-primary" href="{{ route('order.return',['order' => $order]) }}" target="_blank"> {{
          __("admin_message.Create a request return")}}</a>
        @endif -->




        @endif



        @endif
      </div>
      <div class="col-xs-12 col-md-6 col-lg-6  text-center invoice-col">
        <h2 class="page-logo ">
          @if(Auth()->user()->company)
            <img src="{{asset('storage/'.Auth()->user()->company->avatar)}}" />
          @else
            <img src="{{asset('logo/defult_avatar.jpg')}}" />
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
        <div class="col-xs-12 col-md-12 col-lg-12 ">
       
        </div>
      </div>



      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
            <th>@if($order->work_type==1){{ __("admin_message.Store Name")}} @else {{ __("admin_message.Restaurant Name")}} @endif</th>
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
            <th>{{ $order->receved_phone }}</th>

          </tr>
          <tr>
            <th>{{ __("app.city")}}</th>
            <th>{{! empty($order->recevedCity) ? $order->recevedCity->trans('title') : ''}}</th>

          </tr>
          <tr>
            <th>{{ __("app.neighborhood")}}</th>
            <th>{{! empty($order->neighborhood_id) ? $order->region->trans('title') : ''}}</th>

          </tr>
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
          @if($order->consignmentNo!=NULL)
          <tr>
            <th>{{__("admin_message.LaBaih consignmentNo")}}</th>
            <th>
                 {{$order->consignmentNo}}
            </th>
          </tr>
          @endif
          @if($order->service_provider!=NULL)
          @if($order->service_provider->email=='labaih@future.sa')
          @if($order->consignmentNo!=NULL)
          <tr>
            <th>{{__("admin_message.LaBaih liveTrackingLink")}}</th>
            <th>
            <a href="https://dev.mylabaih.com/track/track/?cn={{$order->consignmentNo}}"
                target="_blank">{{__("admin_message.LaBaih liveTrackingLink")}}</a>            </th>
          </tr>
          @endif  
          @if($order->consignmentNo !=NULL)
          <tr>
            <th>{{__("admin_message.LaBaih shipmentLabel")}}</th>
            <th>
            <!-- <a href="{{url('order/print/'.$order->consignmentNo.'')}}"
            target="_blank">{{__("admin_message.LaBaih shipmentLabel")}}</a>  -->
            <a href="https://dev.mylabaih.com/partners/api/order/printlabel?api_key=ef1a3633146e8496fea7dcff4222fa5c0878ef9e&consignmentNo={{$order->consignmentNo}}" download=""
             >{{__("admin_message.LaBaih shipmentLabel")}}</a>    
                   
             </th>
          </tr>
          @endif
          @endif
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
            <th>{{__("app.price")}}</th>

            
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
              <th>{{$product->price}}</th>

               
                
            </tr>
            @endforeach
        </tbody>
      </table>

    </div>
  @endif

    <div class="row">
      <h3>{{__("app.Requests to OTP client")}}</h3>


      <table class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
            {{-- <th>#</th> --}}
            <th>{{__("admin_message.code")}}</th>
            <th>{{__("admin_message.Delegate")}}</th>
            <th>{{__("admin_message.status")}}</th>
            <th>{{__("admin_message.confirmation")}}</th>
            <th>{{__("admin_message.availabe to")}}</th>
            <th>{{__("admin_message.created date")}}</th>
            <th>{{__("admin_message.Delete")}}</th>

          </tr>
        </thead>
        <tbody>
          <?php $count = 1;
                            $date = now()->format('Y-m-d');

                            ?>
          @foreach ($otps as $i=>$otp)
          @if($otp->validate_to<$date) <tr style="color: red;">

            @else
            <tr>

              @endif

              {{-- <th>{{$i+1}}</th> --}}
              <th>{{$otp->code}}</th>
              <th>{{$otp->delegate->name}}</th>
              <th>{{$otp->status->trans('title')}}</th>
              <th>
                @if($otp->is_used==0)
                {{__("admin_message.Not confirmed")}}
                @else
                {{__("admin_message.confirmation")}}
                @endif
              </th>
              @if($otp->validate_to<$date) <th style="color: red;"> {{$otp->validate_to}}</th>
                @else
                <th> {{$otp->validate_to}}</th>


                @endif
                <th> {{$otp->created_at}}</th>
                <!-- <th>
                  <form class="pull-right" style="display: inline;" action="{{route('otp.delete', $otp->id)}}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                      onclick="return confirm('Do you want Delete This Record ?');">
                      <i class="fa fa-trash" aria-hidden="true"></i> {{__("admin_message.Delete")}}
                    </button>
                  </form>
                </th> -->
            </tr>
            @endforeach
        </tbody>
      </table>

    </div>


  

    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-12">
        <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
          {{__("admin_message.Print")}}</a>
        <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
          <i class="fa fa-bell"></i>
          {{__("admin_message.Send notifications to the client")}} </button>
        <a class="btn btn-info pull-right printhidden"
          href="{{route('service_provider_orders.index',['work_type'=>$order->work_type])}}"><i
            class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>
        <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank"> {{ __("admin_message.Send a message for evaluation") }}</a>
        <button type="button" class="btn btn-success pull-center printhidden" data-toggle="modal"
          data-target="#Change_status">
         
          {{__("app.Change_status")}} </button>

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
          <h4 class="modal-title"> {{__("admin_message.Send notifications to the client")}} </h4>
        </div>
        <form action="{{route('notifications.store')}}" method="POST">
          <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="name">{{__("admin_message.Title")}}</label>
              <input type="text" class="form-control" name="title" placeholder="{{__(" admin_message.Title")}}"
                required>
              @error('title')
              <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="name">{{__("admin_message.Message")}}</label>
              <textarea rows="3" class="form-control" name="message" placeholder="{{__(" admin_message.Message")}}"
                required></textarea>

            </div>
            <input type="hidden" name="notification_from" value="{{Auth()->user()->id}}">
            <input type="hidden" name="notification_to" value="{{$order->user_id}}">
            <input type="hidden" name="notification_type" value="order">
            <input type="hidden" name="notification_to_type" value="client">
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
  <!-- change status  -->
    <!-- /.content -->
    <div class="modal fade" id="Change_status">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"> @lang('app.Change_status')</h4>
        </div>
        <form action="{{ route('service_provider_orders.change_status') }}" method="POST">
                                        <input type="hidden" name="order_id[]" value="{{$order->id}}" id="ordersId">
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