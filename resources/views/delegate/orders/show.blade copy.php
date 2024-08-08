@extends('layouts.master')
@section('pageTitle', 'Order : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- @include('layouts._header-form', ['title' => __("admin_message.Order"), 'type' =>__("admin_message.View"), 'iconClass' => 'fa-truck', 'url' =>
    route('client-orders.index'), 'multiLang' => 'false']) -->
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-6 " style="float:right">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> @lang('app.Orders')
                    <small class="pull-left">@lang('app.Created_date'): {{$order->created_at}}</small>
                </h2>
            </div>
            <div class="col-xs-6" style="float:left">
                
                <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank">@lang('app.Send_an_invitation_to_evaluate')</a>
                
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">

            <!-- /.col -->
            <div class="col-sm-12 invoice-col">
                <div class="col-sm-6 ">
                    
                    {!! QrCode::size(150)->generate($order->order_id); !!}
                </div>
                <div class="col-sm-6 ">
                    <b>@lang('app.order') #{{$order->order_id}}</b><br>
                    <br>
                    <b> @lang('app.tracking_id'):</b> {{$order->tracking_id}}<br>
                    @if($order->work_type==1)

                    <b>@lang('app.ship_date') :</b> {{$order->pickup_date}}<br>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 invoice-col">
                <strong class="h2" style="padding: 15px;">@lang('app.from') </strong>
                <address>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.name') : </span>{{ ! empty($order->user) ? $order->user->store_name : '' }}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.phone') : </span>{{$order->sender_phone}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.email') : </span>{{! empty($order->user) ?  $order->user->email : ''}}</p>
                            <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.Google_map') : </span><a href="https://www.google.com/maps/@ {{! empty($order->address) ?  $order->address->longitude : ''}},{{! empty($order->address) ?  $order->address->latitude : ''}},15z?entry=ttu" target="_blank" rel="noopener noreferrer">google map Store</a>
                  </p>
                </address>
            </div>
            <!-- /.col -->
          <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
                <strong class="h3" style="padding: 15px;">@lang('app.to') </strong>
                <address>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.name') : </span>{{$order->receved_name}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.phone') : </span> <a href="https://web.whatsapp.com/send?text=السلام عليكم مندوب التوصيل من شركه اون ماب للشحن يرجى ارسال اللوكيشن&phone={{$order->receved_phone}}">{{$order->receved_phone}}</a></p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.city') : </span>{{! empty($order->recevedCity) ?  $order->recevedCity->title : ''}}</p>
                            <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.neighborhood') : </span>{{! empty($order->region_id) ?  $order->region->title : ''}}</p>
                          
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.address') : </span>{{$order->receved_address}}</p>
                    @if($order->work_type==1)
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.email') : </span>{{$order->receved_email}}</p>
                   @endif
                            <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.address_details')  : </span>{{$order->receved_address_2}}</p>
                          
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">@lang('app.amount') : </span>{{$order->amount}}</p>  
                    @if($order->work_type==1)          
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">@lang('app.number_count')  : </span>{{$order->number_count}}</p>  
                    
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">@lang('app.reference_number') : </span>{{$order->reference_number}}</p>            
                                
                            
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.contents'): </span>{{$order->order_contents}}</p>
                   @else
                   <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.amount_paid') : </span>
                            @if($order->amount_paid==0)
                            غير مدفوع
                            @else
                                مدفوع
                            @endif
                   <!-- <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.longitude'): </span>{{$order->longitude}}</p>
                   <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.latitude'): </span>{{$order->latitude}}</p> -->
                   <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.Google_map'): </span><a href="https://www.google.com/maps/@ {{$order->longitude}},{{$order->latitude}},15z?entry=ttu" target="_blank" rel="noopener noreferrer">google map client</a>
                  </p>
                   @endif
                   @if($order->payment_method!=NULL)
                   <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px"> @lang('app.payment_method')</span>
        @if($order->payment_method==1)
        @lang('app.cash')
                @elseif($order->payment_method==2)
                @lang('app.network')
        @endif
</p>
  @endif
                   @if($order->real_image_confirm!=NULL)
                   <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">@lang('app.real_image_confirm')</span>
                        
                            <img src="{{asset('storage/'.$order->real_image_confirm)}}" />

</p>
                    @endif
                </address>
            </div>
           <div class="row">
           @if(isset($order->product))
                @foreach($order->product as $product)
                <div class="form-group row">
                          <div class="col-lg-1 form-label">
                                 اسم  المنتج        
                           </div>
                           <div class="col-lg-3 ">
                               <input disabled class="form-control" value="{{$product->product_name}}" type="text" name="product_name[]" placeholder=" أسم المنتج"/>
                           </div>
                           <div class="col-lg-3 ">
                               <input disabled class="form-control" value="{{$product->size}}" type="text" name="size[]" placeholder="الحجم"/>
                           </div>
                           <div class="col-lg-2 ">
                               <input disabled class="form-control" value="{{$product->number}}" type="number" name="number[]" placeholder="العدد"/>
                           </div><div class="col-lg-2 ">
                               <input disabled class="form-control" value="{{$product->price}}"  type="number" name="price[]" placeholder="السعر"/>
                           </div>
                           
                           <br>
                           <!-- <div class="col-lg-1 ">
                               <button class=" btn-info color" type="button" placeholder="العدد"> <i class="fa fa-solid fa-plus"></i></button>
                           </div> -->
                          
                </div>
                @endforeach
                @endif
           </div>
            <!-- <div id="mapCanv" style="width:100%;height:400px"></div> -->


            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>@lang('app.print') </a>
                <a class="btn btn-info pull-right" href="{{route('delegate-orders.index')}}"><i class="fa fa-reply-all"></i> @lang('app.back_to') @lang('app.Orders')</a>
            </div> </a>
            </div>

        </div>
 
    </section>
    <!-- /.content -->

</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRlTT-DjfcAKMEY-0ePypWkjfEiKrCdyE&language=ar"></script>
    <script type="text/javascript">
        let map, marker;

        function initialise() {
            navigator.geolocation.getCurrentPosition(function(position) {
                // document.getElementById("latitude").value = <?= $order->latitude ?>;
                // document.getElementById("longitude").value = <?= $order->longitude ?>;
                var latitude =  <?= $order->latitude ?>;

                var longitude =  <?= $order->longitude ?>;
                console.log(position.coords)
                var mapCanvas = document.getElementById("mapCanv");

                var myCenter = new google.maps.LatLng(latitude, longitude);
                var mapOptions = {
                    center: myCenter,
                    zoom: 14
                };
                map = new google.maps.Map(mapCanvas, mapOptions);
                marker = new google.maps.Marker({
                    position: myCenter,
                    draggable: true,
                });
                marker.setMap(map);
                geocodePosition(marker.getPosition());
                new google.maps.event.addListener(marker, 'dragend', function() {

                    geocodePosition(marker.getPosition());
                    $("#latitude").val(this.getPosition().lat());
                    $("#longitude").val(this.getPosition().lng());

                });

            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
            //var geoloccontrol = new klokantech.GeolocationControl(map, 20);

        }
        $(".locatinId").bind('change paste keyup', function() {
            var latitude = document.getElementById("latitude").value;

            var longitude = document.getElementById("longitude").value;
            var latLng = new google.maps.LatLng(latitude, longitude);
            map.setCenter(latLng);
            marker.setPosition(latLng);

        })
        google.maps.event.addDomListener(window, 'load', initialise);


        function geocodePosition(pos) {
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: pos

            }, function(responses) {
                if (responses && responses.length > 0) {
                    $("#address_ar-field").val(responses[0].formatted_address);
                }
            });
        }
    </script>


@endsection
