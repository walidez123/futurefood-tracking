@extends('layouts.master')
@section('pageTitle',__('app.order', ['attribute' => '']))
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
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.add'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>@lang('app.add') @lang('app.order', ['attribute' => ''])
                    <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach -->
                </ul>
            </div>
            @endif

                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <form action="{{route('client-orders.store')}}" method="POST">
                @csrf
                <div class="col-sm-6 invoice-col">
                    @lang('app.from') (@lang('app.sender'))
                    <address>
                        <!--  -->
                        <div class="form-group">
                            <label>{{ __('admin_message.Client') }}</label>
                            @if(isset($clients))
                            <select class="form-control select2" id="store_client_id" name="user_id" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.client')])</option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}" data-store_address_id="" data-region="" data-city=""
                                    data-address1="" data-address2=""
                                    data-phone="">{{$client->name}} | {{$client->store_name}}
                                </option>
                                @endforeach
                            </select>
                            @endif


                        </div>




                        <!--  -->
                        <div class="form-group">
                            <label>{{ __('app.address') }}</label>

                            <select class="form-control select2" id="sender_address" name="sender_city" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                              
                            </select>
                            <input type="hidden" name="store_address_id" id="store_address_id">


                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone"
                                name="sender_phone" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <input type="text" class="form-control" placeholder="City" id="sender_city" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.neighborhood')</label>
                            <input type="text" class="form-control" placeholder="Region" id="sender_region" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.address')</label>
                            <input type="text" class="form-control" placeholder="Addres" id="sender_address1"
                                name="sender_address" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.ship_date')</label>
                            <input type="date" class="form-control" id="date" name="pickup_date" value=" " placeholder="date"
                                required>
                        </div>
                       
                        <div class="form-group">
                            <label>@lang('app.Number')</label>
                            <input type="number" class="form-control" min="1" value="1" name="number_count"  >
                        </div>
                         <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control"  name="reference_number" value=""  >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('app.weight')</label>
                            <input type="number" class="form-control" min="0" value="0" name="order_weight"  >
                        </div>
                         
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @lang('app.to') (@lang('app.receiver'))
                    <address>
                        <div class="form-group">
                            <label>@lang('app.name', ['attribute' => ''])</label>
                            <input type="text" class="form-control" name="receved_name" required>
                            <!--  -->
                            @error('receved_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" name="receved_phone"  placeholder="{{__('admin_message.phoneMessage')}}" >
                            @error('receved_phone')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        <div class="form-group">
                        <label>@lang('app.city')</label>
                            <select  class="form-control select2" id="city_id" name="receved_city" required>
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option  value="{{$city->id}}">{{$city->trans('title')}}</option>
                                @endforeach
                            </select>
                            @error('receved_city')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                         <div class="form-group">
                         <label>@lang('app.neighborhood')</label>
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id" required>
                            <option class="" value="">@lang('app.select', ['attribute' => __('app.neighborhood')])</option>

                               
                            </select>
                            @error('neighborhood_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                       
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address" placeholder="@lang('app.detials', ['attribute' => __('app.address')])"></textarea>
                            @error('receved_address')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.email')</label>
                            <input type="email" class="form-control" name="receved_email">
                            @error('receved_email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input required type="number" class="form-control" min="0" value="0" name="amount"  >
                            @error('amount')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        
                        
                        <div class="form-group">
                            <label>@lang('app.order', ['attribute' => __('app.contents')])</label>
                            <textarea class="form-control" name="order_contents"></textarea>
                            @error('contents')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                        <div class="form-group">
                            <label>{{__('admin_message.Notes')}}  </label>
                            <textarea class="form-control" name="receved_notes"></textarea>
                            @error('Notes')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                        </div>
                    </address>
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right" value="{{__('app.order', ['attribute' => __('app.add')])}}">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.row -->
   </div>


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
