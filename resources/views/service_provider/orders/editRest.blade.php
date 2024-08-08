@extends('layouts.master')
@section('pageTitle',__("admin_message.Order Edit"))
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __("admin_message.Order Edit"), 'type' => __('app.edit'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> @lang('app.order', ['attribute' => __('app.edit')])

                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <form action="{{route('service_provider_orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-6 invoice-col">
                    @lang('app.from') (@lang('app.sender'))
                    <address>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.select', ['attribute' => __('app.address')])</label>
                            <select class="form-control" id="sender_address" name="sender_city" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @foreach ($addresses as $address)
                                <option {{($order->store_address_id == $address->id) ? 'selected' : ''}} value="{{! empty( $address->city ) ? $address->city->id : "" }}" data-city="{{! empty( $address->city ) ? $address->city->trans('title') : "" }}"
                                    data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                    data-phone="{{$address->phone}}">{{$address->address}} | {{! empty( $address->city ) ? $address->city->trans('title') : $address->description }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone"
                                name="sender_phone" value="{{! empty($order->address) ? $order->address->phone : ''}}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.city')</label>
                            <input type="text" value="{{ ! empty( $order->senderCity ) ? $order->senderCity->trans('title') : '' }}" class="form-control"  id="sender_city" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.address')</label>
                            <input type="text" class="form-control" value="{{! empty($order->address) ? $order->address->address : ''}}"  id="sender_address1"
                                name="sender_address" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                required>{{! empty($order->address) ? $order->address->description : ''}}</textarea>
                        </div>

                        <!-- <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.ship_date')</label>
                            <input type="date" class="form-control" value="{{$order->pickup_date}}" id="date" name="pickup_date" placeholder="date"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.tips')</label>
                            <textarea class="form-control " name="sender_notes">{{$order->sender_notes}}</textarea>
                        </div> -->
                        <div class="form-group">
                            <label>{{__("admin_message.Payment status")}} </label>
                            <select class="form-control select2" id="amount_paid" name="amount_paid" required>
                                @if($order->amount_paid==0)
                                <option selected value="0">{{__("admin_message.UnPaid")}}</option>
                                @else
                                 <option selected value="1"> {{__("admin_message.Paid")}}</option>
                                 @endif

                               
                            </select>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @lang('app.to') (@lang('app.receiver'))
                    <address>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.name', ['attribute' => ''])</label>
                            <input type="text" class="form-control" value="{{$order->receved_name}}" name="receved_name"  required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.phone')</label>
                            <input type="text" class="form-control" value="{{$order->receved_phone}}" name="receved_phone"  required>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">@lang('app.city')</label>
                            <select class="form-control select2" id="city_id" name="receved_city" required>
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option {{($order->receved_city == $city->id) ? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">@lang('app.neighborhood')</label>
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id" >
                                @if($neighborhood!=NULL)
                                <option selected value="{{$neighborhood->id}}">{{$neighborhood->trans('title')}}</option>
                               @endif
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.address')</label>
                            <input type="text" class="form-control"  value="{{$order->receved_address}}" name="receved_address">
                        </div> -->
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address">{{$order->receved_address}}</textarea>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.email')</label>
                            <input type="text" class="form-control"  value="{{$order->receved_email}}" name="receved_email">
                        </div> -->
                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input type="number" class="form-control" min="0" value="{{$order->amount}}" name="amount"  required>
                        </div>
                        <!-- <div class="form-group">
                            <label>@lang('app.Number')</label>
                            <input type="number" class="form-control" min="1" value="{{$order->number_count}}" name="number_count"  >
                        </div> -->
                        
                        <!-- <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control"  name="reference_number" value="{{$order->reference_number}}"  >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.weight')</label>
                            <input type="number" class="form-control" min="0"  name="order_weight" value="{{$order->order_weight}}"  >
                        </div> -->
                        
                        
                        <!-- <div class="form-group">
                            <label>@lang('app.order', ['attribute' => __('app.contents')])</label>
                            <textarea class="form-control" name="order_contents">{{$order->order_contents}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.tips')</label>
                            <textarea class="form-control" name="receved_notes">{{$order->receved_notes}}</textarea>
                        </div> -->
                        <div class="form-group">
                            <label>{{__("admin_message.longitude")}}</label>
                            <input type="text" value="{{$order->longitude}}" class="form-control" name="longitude">
                        </div>
                        <div class="form-group">
                            <label>{{__("admin_message.latitude")}}  </label>
                            <input type="text" value="{{$order->latitude}}" class="form-control" name="latitude">
                        </div>
                    </address>
                </div>
                <div class="row no-print">
                @if(isset($products))
                @foreach($products as $product)
                <div class="form-group row">
                          <div class="col-lg-1 form-label">
                          {{__("admin_message.product_name")}}                           </div>
                           <div class="col-lg-3 ">
                               <input class="form-control" value="{{$product->product_name}}" type="text" name="product_name[]" placeholder="{{__("admin_message.product_name")}}"/>
                           </div>
                           <div class="col-lg-3 ">
                               <input class="form-control" value="{{$product->size}}" type="text" name="size[]" placeholder="الحجم"/>
                           </div>
                           <div class="col-lg-2 ">
                               <input class="form-control" value="{{$product->number}}" type="number" name="number[]" placeholder="العدد"/>
                           </div><div class="col-lg-2 ">
                               <input class="form-control" value="{{$product->price}}"  type="number" name="price[]" placeholder="السعر"/>
                           </div>
                           <div class="cardiv">
                           </div>
                           <br>
                           <!-- <div class="col-lg-1 ">
                               <button class=" btn-info color" type="button" placeholder="العدد"> <i class="fa fa-solid fa-plus"></i></button>
                           </div> -->
                          
                </div>
                @endforeach
                @endif
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right" value="{{__('app.order', ['attribute' => __('app.update')])}}">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.row -->



        <!-- this row will not appear when printing -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$('#sender_address').on('change', function() {
var selected = $(this).find('option:selected');
var phone = selected.data('phone');
var city = selected.data('city');
var address_1 = selected.data('address1');
var address_2 = selected.data('address2');
var store_address_id=selected.data('store_address_id');
$('#store_address_id').val(store_address_id);

$('#sender_phone').val(phone);
$('#sender_city').val(city);
$('#sender_address1').val(address_1);
$('#sender_address_2').val(address_2);

});
$(function () {
         $('.select2').select2()
});
</script>
@endsection
