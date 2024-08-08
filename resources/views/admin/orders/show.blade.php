@extends('layouts.master')
@section('pageTitle',__("admin_message.Order").' : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
  <style>
    table {
     
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
      height : 60px;
    }

   
  </style>
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-6 left" >
        @if($order->work_type==1)
        @if(Auth()->user()->company_setting!=null &&
        Auth()->user()->company_setting->status_return_shop==$order->status_id)

        @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();
        @endphp

        @if($order->is_returned==0 & $count==0)
        <a class="btn btn-primary" href="{{ route('order.return',['order' => $order]) }}" target="_blank">{{
          __("admin_message.Create a request return")}}</a>
        @endif
        @endif
        @else
        @if(Auth()->user()->company_setting!=null &&
        Auth()->user()->company_setting->status_return_res==$order->status_id)
        @php $count=\App\Models\Order::where('return_order_id',$order->id)->count();

        @endphp

        @if($order->is_returned==0 & $count==0)
        <a class="btn btn-primary" href="{{ route('order.return',['order' => $order]) }}" target="_blank"> {{
          __("admin_message.Create a request return")}}</a>
        @endif

        @endif

        @endif
      </div>
       
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">

      <!-- /.col -->
      <div class="col-xs-12 col-md-12 col-lg-12  invoice-col">
        <div class="col-xs-12 col-md-3 col-lg-3 ">
          {!! QrCode::size(100)->generate($order->order_id) !!}
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
          <!-- <br>
          @lang('website.tracking'):</b> {!! QrCode::size(50)->generate(route("track.order",['tracking_id'=>$order->tracking_id])) !!} -->
        </div>
        <div class="col-xs-12 col-md-3 col-lg-12 ">

      </div>



      <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">

        <table>
          <tr>
            <th>{{ __("order.sender_name")}}</th>
            <th> {{! empty($order->user) ? $order->user->store_name : ''}}</th>

          </tr>
          @if($order->address !=NULL)

          @if($order->address->address)
          <tr>
            <th>{{ __("admin_message.addressname")}}</th>
            <th>{{ $order->address->address }}</th>
          </tr>
          @endif
          @endif
          <tr>
            <th>{{ __("admin_message.addressdescription")}}</th>
            <th>{{! empty($order->address) ? $order->address->description : ''}}</th>

          </tr>
          @if($order->address)
          @if($order->address!=NULL)
              <tr>
                <th>{{ __("admin_message.Phone")}}</th>
                <th>{{!$order->address->phone }}  <a href="tel:{{$order->address->phone }}" style="padding:5px"><i class="fa fa-phone fa-1x"></i></a> <a href="https://api.whatsapp.com/send?phone={{$order->address->phone }}"  style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x" style="color:green"></i></a></th>
              </tr>
          @endif
         
            @if($order->address->latitude)
            <tr>
              <th>{{ __("admin_message.location on map")}}</th>
              <th><a
                  href="https://www.google.com/maps/search/?api=1&query={{ $order->address->latitude }},{{ $order->address->longitude }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
            </tr>
            @elseif($order->address->link)
            <tr>
              <th>{{ __("admin_message.location on map")}}</th>
              <th><a
                  href="{{ $order->address->link }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a></th>
            </tr>
            @endif

          @endif  

          @if($order->delegate != NULL)

            <tr>
              <th>{{ __("admin_message.delegate")}}</th>
              <th> 
              @if($order->delegate !=NULL)

                {{$order->delegate->name}}
                @endif
              </th>
            </tr>
          @endif

          @if($order->work_type==1)
          <tr>
            <th>{{ __("admin_message.Order content")}}</th>
            <th>{{$order->order_contents}}</th>
          </tr>
          <tr>
            <th>{{ __("admin_message.number")}}</th>
            <th> {{$order->number_count}}</th>
          </tr>
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
            
            <th>{{ substr_replace($order->receved_phone, '', 3, 1) }} <a href="tel:{{$order->receved_phone}}" style="padding:5px">
              <?php 
              $message=$order->user->company_setting->what_up_message;
              $message_ar=$order->user->company_setting->what_up_message_ar;

              $bodytag = str_replace("[order_number]", $order->order_id,$message);
              $bodytag_ar = str_replace("[order_number]", $order->order_id,$message_ar);
              $bodytag = str_replace("[store_name]", !empty( $order->user) ? $order->user->store_name : '',$bodytag);
              $bodytag_ar = str_replace("[store_name]", !empty( $order->user) ? $order->user->store_name : '',$bodytag_ar); ?>

              <a href="https://api.whatsapp.com/send?phone={{ $order->receved_phone }}&text={{ urlencode($bodytag_ar) }}" style="padding:5px">
                  <i class="fa-brands fa-whatsapp fa-2x" style="color:green"></i>
              </a>            </th>

          </tr>
          @if(! empty($order->recevedCity))
          <tr>
            <th>{{ __("app.city")}}</th>
            <th>
            @if($order->recevedCity !=NULL)

              {{$order->recevedCity->trans('title') }}
            @endif</th>

          </tr>
          <tr>
            <th>{{ __("app.neighborhood")}}</th>
           
            <th>
            @if($order->region !=NULL)
              {{$order->region->trans('title') }}
            @endif</th>

          </tr>
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
              <img width="50px" height="50px" src="{{asset('storage/'.$order->real_image_confirm)}}" />

            </th>
          </tr>
          @endif

          @if($order->consignmentNo!=NULL)
          <tr>
            <th>{{__("admin_message.SMB consignmentNo")}}</th>
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
            <th>{{__("admin_message.SMB shipmentLabel")}}</th>
            <th>
            <!-- <a href="{{url('order/print/'.$order->consignmentNo.'')}}"
            target="_blank">{{__("admin_message.LaBaih shipmentLabel")}}</a>  -->
            <a href="https://dev.mylabaih.com/partners/api/order/printlabel?api_key=ef1a3633146e8496fea7dcff4222fa5c0878ef9e&consignmentNo={{$order->consignmentNo}}" download=""
             >{{__("admin_message.SMB shipmentLabel")}}</a>    
                   
             </th>
          </tr>
          @endif
          @else
          @if($order->consignmentNo !=NULL)
          @if($order->tracking_url!=null && $order->public_pdf_label_url !=null)
          <tr>
            <th>{{__("admin_message.SMB shipmentLabel")}}</th>
            <th>
            <a href="{{$order->public_pdf_label_url}}"
            target="_blank">{{__("admin_message.SMB shipmentLabel")}}</a> 
          </tr>
          <tr>
            <th>{{__("website.tracking")}}</th>
            <th>
            <a href="{{$order->tracking_url}}"
            target="_blank">{{__("website.tracking")}}</a> 
          </tr>


          @else
          <tr>
            <th>{{__("admin_message.confirmation")}}</th>
            <th>
            <a href="{{url('admin/client-orders/confirmSmb/'.$order->consignmentNo.'')}}"
            target="_blank">{{__("admin_message.confirmation")}}</a> 
          </tr>
          
          @endif
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
          @if($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name =='salla')
          <th>{{__("goods.skus")}}</th>

          @else
          <th>{{__("app.size")}}</th>

          @endif
            <th>{{__("app.number")}}</th>
            <!-- <th>{{__("app.price")}}</th> -->

            
          </tr>
        </thead>
        <tbody>
          @foreach ($order->product as $i=>$product)
            <tr>
              <th>{{$product->product_name}}
              </th>
              @if($order->providerOrder?->provider_name =='zid' || $order->providerOrder?->provider_name =='salla')
              <th>{{$product->sku}}</th>

              @else
              <th>{{$product->size}}</th>
              @endif
              <th>{{$product->number}}</th>
              <!-- <th>{{$product->price}}</th> -->
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
    </div>
  @endif


    @include('admin.orders.show_sections.otp')

    @include('admin.orders.show_sections.notification')




  

    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-12">
      <!-- policy print  -->
        <form action="{{route('order_client.print-invoice')}}" method="POST" style="display:inline-block;">
        <input type="hidden" name="order_id[]" value="{{$order->id}}" id="ordersId">
         @csrf
      
         <button type="submit" class="btn btn-default printhidden">   <i class="fa fa-print"></i>  @if($order->work_type == 2) @lang('order.print_order') @else @lang('order.print_policy') @endif</button>
         <!-- </div> -->
        </form>

    
          <!--  -->
       
       
          <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
          data-target="#send-notification">
          <i class="fa fa-bell"></i>
          {{__("admin_message.Send notifications to the client")}} </button>
        <a class="btn btn-info pull-right printhidden"
          href="{{route('client-orders.index',['work_type'=>$order->work_type])}}"><i
            class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>
        @if (in_array('send_rate_order', $permissionsTitle))

        <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank"> {{ __("admin_message.Send a message for evaluation") }}</a>
        @endif
        <!--  run sheet -->


        <!-- <a class="btn btn-primary" href="{{route('client-orders.run_sheet',['id'=>$order->id])}}"> {{ __("admin_message.run sheet") }}</a> -->


        <!-- run sheet -->
        @if (in_array('change_status', $permissionsTitle))

        <button type="button" class="btn btn-success pull-center printhidden" data-toggle="modal"
          data-target="#Change_status">
         
          {{__("app.Change_status")}} </button>
        @endif

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
        <form action="{{ route('order.change_status_all') }}" method="POST">
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