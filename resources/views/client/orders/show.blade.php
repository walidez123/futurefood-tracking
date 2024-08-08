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



            <div class="col-xs-6 printhidden" style="float:left">

                {{-- <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank">{{ __("admin_message.Send
          a message for evaluation") }} </a> --}}
                @if($order->work_type==1)
                @if(Auth()->user()->company_setting!=null &&
                Auth()->user()->company_setting->status_can_return_shop==$order->status_id)


                @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();

                @endphp

                @if($order->is_returned==0 & $count==0)
                <a class="btn btn-primary" href="{{ route('orderclient.return',['order' => $order]) }}" target="_blank">{{
          __("admin_message.Create a request return")}}</a>
                @endif
                @endif
                @else
                @if(Auth()->user()->company_setting!=null &&
                Auth()->user()->company_setting->status_can_return_res==$order->status_id)
                @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();

                @endphp

                @if($order->is_returned==0 & $count==0)
                <a class="btn btn-primary" href="{{ route('order.return',['order' => $order]) }}" target="_blank"> {{
          __("admin_message.Create a request return")}}</a>
                @endif




                @endif



                @endif
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6  text-center invoice-col">
                <h2 class="page-logo ">
                    @if(Auth()->user()->company)
                    <img src="{{asset('storage/'.Auth()->user()->company_setting->logo)}}" />
                    @else
                    <!-- <img src="{{asset('logo/defult_avatar.jpg')}}" /> -->
                    <img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75">
                    < @endif </h2>
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
                    <b>{{ __("admin_message.order status")}}:</b> {{! empty($order->clientstatus) ?
          $order->clientstatus->trans('title') : ''}}
                    <!-- <div class="col-xs-12 col-md-3 col-lg-12 ">

@lang('website.tracking'):</b> {!! QrCode::size(50)->generate(route("track.order",['tracking_id'=>$order->tracking_id])); !!}



</div> -->

                </div>

            </div>



            <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

                <table>
                    <tr>
                        <th>@if($order->work_type==1){{ __("admin_message.Store Name")}} @elseif($order->work_type==2) {{
              __("admin_message.Restaurant Name")}} @elseif($order->work_type==3) {{ __("admin_message.Warehouse
              Clients")}} @elseif($order->work_type==4) {{ __("fulfillment.fulfillment_clients")}} @endif</th>
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

                    @if($order->address)
                    <tr>
                        <th>{{ __("admin_message.location on map")}}</th>
                        <th><a href="https://www.google.com/maps/search/?api=1&query={{ $order->address->latitude }},{{ $order->address->longitude }}"
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
                        <th>{{ substr_replace($order->receved_phone, '', 3, 1) }}</th>

                    </tr>
                    <tr>
                        <th>{{ __("app.city")}}</th>
                        <th>{{! empty($order->recevedCity) ? $order->recevedCity->title : ''}}</th>

                    </tr>
                    <tr>
                        <th>{{ __("app.neighborhood")}}</th>
                        <th>{{! empty($order->neighborhood_id) ? $order->region->title : ''}}</th>

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
                            <img width="50px" height="50px" src="{{asset('storage/'.$order->real_image_confirm)}}" />

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
                        @if($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name
                        =='salla')
                        <th>{{__("goods.skus")}}</th>

                        @else
                        <th>{{__("app.size")}}</th>

                        @endif
                        <th>{{__("app.number")}}</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($order->product as $i=>$product)
                    <tr>
                        <th>{{$product->product_name}}





                        </th>
                        @if($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name
                        =='salla')
                        <th>{{$product->sku}}</th>

                        @else
                        <th>{{$product->size}}</th>
                        @endif
                        <th>{{$product->number}}</th>


                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        @endif

        @if($order->goods && count($order->goods) > 0)
        <div class="row">
            <h3>{{__("app.order products")}}</h3>


            <table class="table table-bordered table-striped table-hover ">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>{{__("app.product name")}}</th>
                        <th>{{__("app.number")}}</th>


                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1;
                $date = now()->format('Y-m-d');

            ?>
                    @foreach ($order->goods as $i=>$product)
                    <tr>
                        <th>{{$product->goods->trans('title')}} | {{$product->goods->SKUS}}</th>
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
                <!-- policy print  -->

                <form action="{{route('order.print-invoice')}}" method="POST" style="display:inline-block;">
                    <input type="hidden" name="order_id[]" value="{{$order->id}}" id="ordersId">
                    @csrf
                    <!-- @if($order->work_type == 2)
         <div class="col-md-1 ">  

         @else
         <div class="col-md-2 ">  
         @endif -->
                    <button type="submit" class="btn btn-default printhidden" value=""> <i class="fa fa-print"></i>
                        @if($order->work_type == 2) @lang('order.print_order') @else @lang('order.print_policy')
                        @endif</button>
                </form>


                <!--  -->
                <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
                    data-target="#send-notification">
                    <i class="fa fa-bell"></i>
                    @lang('app.notifications', ['attribute' => __('app.send')])
                </button>
                <a class="btn btn-info pull-right printhidden" href="{{route('orders.index', $order->id)}}"><i
                        class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>
                @if (Auth()->user()->available_edit_status == $order->status_id)
                <a href="{{route('orders.edit', $order->id)}}" class="btn btn-success pull-right printhidden"><i
                        class="fa fa-credit-card"></i> @lang('app.order', ['attribute' => __('app.edit')])
                </a>
                @endif
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
                    <h4 class="modal-title"> @lang('app.notifications', ['attribute' => __('app.send')])
                    </h4>
                </div>
                <form action="{{route('notifications.store')}}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__("admin_message.Title")}}</label>
                            <input type="text" class="form-control" name="title"
                                placeholder="{{__('admin_message.Title')}}" required>
                            @error('title')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{__("admin_message.Message")}}</label>
                            <textarea rows="3" class="form-control" name="message"
                                placeholder="{{__('admin_message.Message')}}" required></textarea>

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