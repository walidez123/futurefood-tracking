@extends('layouts.master')
@section('pageTitle', __('app.order', ['attribute' => 'edit']))
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
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.edit'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> @lang('app.order', ['attribute' => __('app.edit')])
                    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <form action="{{route('orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-6 invoice-col">
                    @lang('app.from') (@lang('app.sender'))
                    <address>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.select', ['attribute' => __('app.address')])</label>
                            <select class="form-control" id="sender_address" name="sender_city" >
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @foreach ($addresses as $address)
                                @if($address->city)
                                <option {{($order->sender_city == $address->city->id) ? 'selected' : ''}} value="{{$address->city->id}}" data-city="{{$address->city->trans('title')}}"
                                    data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                    data-phone="{{$address->phone}}">{{$address->address}} | {{$address->city->trans('title')}}
                                </option>
                                @else
                                <option {{($order->store_address_id == $address->id) ? 'selected' : ''}} value="{{$address->id}}" 
                                    data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                    data-phone="{{$address->phone}}">{{$address->address}}
                                </option>



                                @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="store_address_id" id="store_address_id">


                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone"
                                name="sender_phone" value="{{$order->sender_phone}}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.city')</label>
                            <input type="text" value="{{ ! empty( $order->senderCity ) ? $order->senderCity->trans('title') : '' }}" class="form-control"  id="sender_city" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.neighborhood')</label>
                            <input type="text" class="form-control" placeholder="Region" id="sender_region" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.address')</label>
                            <input type="text" class="form-control" value="{{$order->sender_address}}"  id="sender_address1"
                                name="sender_address" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                required>{{$order->sender_address_2}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.ship_date')</label>
                            <input type="date" class="form-control" value="{{$order->pickup_date}}" id="date" name="pickup_date" placeholder="date"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.tips')</label>
                            <textarea class="form-control " name="sender_notes">{{$order->sender_notes}}</textarea>
                        </div>
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
                        <label>@lang('app.city')</label>
                            <select class="form-control select2" id="receved_city" name="receved_city" required >
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option {{($order->receved_city == $city->id) ? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label>@lang('app.neighborhood')</label>
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id" >
                                @if($neighborhood!=NULL)
                                <option selected value="{{$neighborhood->id}}">{{$neighborhood->title}}</option>
                               @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.address')</label>
                            <input type="text" class="form-control"  value="{{$order->receved_address}}" name="receved_address">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address_2">{{$order->receved_address_2}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.email')</label>
                            <input type="text" class="form-control"  value="{{$order->receved_email}}" name="receved_email">
                        </div>
                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input type="number" class="form-control" step=".01" min="0" value="{{$order->amount}}" name="amount"  required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.Number')</label>
                            <input type="number" class="form-control" min="1" value="{{$order->number_count}}" name="number_count"  >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control"  name="reference_number" value="{{$order->reference_number}}"  >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.weight')</label>
                            <input type="number" class="form-control" step="any" name="order_weight" value="{{$order->order_weight}}"  >
                        </div>
                        
                        
                        <div class="form-group">
                            <label>@lang('app.order', ['attribute' => __('app.contents')])</label>
                            <textarea class="form-control" name="order_contents">{{$order->order_contents}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.tips')</label>
                            <textarea class="form-control" name="receved_notes">{{$order->receved_notes}}</textarea>
                        </div>
                    </address>
                </div>
                <div class="row no-print">
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
$(document).ready(()=>{
    var selected =  $("#sender_address").find('option:selected');
var phone = selected.data('phone');
var city = selected.data('city');
var region = selected.data('region');
var store_address_id=selected.data('store_address_id');
$('#store_address_id').val(store_address_id);

var address_1 = selected.data('address1');
var address_2 = selected.data('address2');

$('#sender_phone').val(phone);
$('#sender_city').val(city);
$('#sender_region').val(region);

$('#sender_address1').val(address_1);
$('#sender_address_2').val(address_2);
        });
$('#sender_address').on('change', function() {
var selected = $(this).find('option:selected');
var phone = selected.data('phone');
var city = selected.data('city');
var region = selected.data('region');

var address_1 = selected.data('address1');
var address_2 = selected.data('address2');
var store_address_id=selected.data('store_address_id');
$('#store_address_id').val(store_address_id);

$('#sender_phone').val(phone);
$('#sender_city').val(city);
$('#sender_region').val(region);

$('#sender_address1').val(address_1);
$('#sender_address_2').val(address_2);

});

$(function () {
         $('.select2').select2()
});
var today = new Date();
var tomorrow = new Date(new Date().getTime()  );

// Set values
$("#date").val(getFormattedDate(today));
$("#date").val(getFormattedDate(tomorrow));
$("#date").val(getFormattedDate(anydate));

// Get date formatted as YYYY-MM-DD
function getFormattedDate (date) {
    return date.getFullYear()
        + "-"
        + ("0" + (date.getMonth() + 1)).slice(-2)
        + "-"
        + ("0" + date.getDate()).slice(-2);
}
</script>


@endsection