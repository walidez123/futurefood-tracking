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
                    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif


                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <form action="{{route('orders.store')}}" method="POST"  id="order-form">
                @csrf
                <div class="col-sm-6 invoice-col">
                    @lang('app.write_sender')
                    <address>
                        <div class="form-group">
                            <label>@lang('app.select', ['attribute' => __('app.address')])</label>
                            <select class="form-control select2" id="sender_address" name="sender_city" >
                                @if (count($addresses) > 1)
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @endif
                                @foreach ($addresses as $address)
                                @if($address->city)
                                    <option {{($address->main_address ==1) ? 'selected' : ''}} value="{{$address->id}}" data-store_address_id="{{$address->id}}"  data-city="{{$address->city->trans('title')}}"
                                        data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                        data-phone="{{$address->phone}}">{{$address->address}} | {{$address->city->trans('title')}}
                                    </option>
                                @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="store_address_id" id="store_address_id">
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone"
                                name="sender_phone" value="{{$user->phone}}" placeholder="{{$user->phone}}" readonly required>
                        </div>

                        
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <input type="text" class="form-control" placeholder="City" id="sender_city" readonly
                                >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.neighborhood')</label>
                            <input type="text" class="form-control" placeholder="Region" id="sender_region" readonly
                                >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.address')</label>
                            <input type="text" class="form-control" placeholder="Addres" id="sender_address1"
                                name="sender_address" readonly >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                ></textarea>
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
                            <input type="number" class="form-control" min="0" step=".01" value="0" name="order_weight"  >
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
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" name="receved_phone"   placeholder="{{__('admin_message.phoneMessage')}}" >
                        </div>
                        <div class="form-group">
                        <label>@lang('app.city')</label>
                            <select  class="form-control select2" id="city_id" name="receved_city" required>
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option  value="{{$city->id}}">{{$city->trans('title')}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="form-group">
                         <label>@lang('app.neighborhood')</label>
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id" >
                            <option class="" value="">@lang('app.select', ['attribute' => __('app.region')])</option>

                               
                            </select>
                        </div>
                       
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address" placeholder="الرجاء كتابه تفاصيل العنوان "></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.email')</label>
                            <input type="text" class="form-control" name="receved_email">
                        </div>
                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input type="number" class="form-control" min="0" step=".01" value="0" name="amount"  >
                        </div>
                        
                        
                        <div class="form-group">
                            <label>@lang('app.order', ['attribute' => __('app.contents')])</label>
                            <textarea class="form-control" name="order_contents"></textarea>
                        </div>
                        <div class="form-group">
                            <label>ملاحظات  </label>
                            <textarea class="form-control" name="receved_notes"></textarea>
                        </div>
                    </address>
                </div>
                @if(Auth()->user()->work ==4)
                 <div class="form-group row">
                    <div class="col-lg-12 form-label">
                        {{__('admin_message.product_name')}}
                    </div>
                    <div class="col-lg-4 ">
                        <select  class="form-control select2" id="good_id" name="good_id[]" required>
                            <option class="" value="">@lang('app.select', ['attribute' => __('admin_message.product_name')])</option>
                            @foreach ($goods as $data)
                            {{-- {{ dd($data->Client_packages_goods->sum('number'))}} --}}
                            <option  value="{{$data->id}}">{{__('goods.instock')}} ({{$data->Client_packages_goods->sum('number')}})| {{$data->SKUS}}| {{$data->trans('title')}}</option>
                            @endforeach
                        </select>
                        @error('good_id')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                   
                    <div class="col-lg-4 ">
                        <input  class="form-control" type="number" step="1" min="1" name="number[]"
                            placeholder='{{__("app.number")}}' />
                        @error('number')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>
                
                <div class="good-card form-group row">
                </div>
                <div style="float: left;" class="col-lg-2 ">
                    <button class=" btn-info color" type="button"> <i class="fa fa-solid fa-plus"></i></button>
                </div>
                <br>
                @endif
                <div class="row no-print">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right" id="submit-button" value="{{__('app.order', ['attribute' => __('app.add')])}}">

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
   document.getElementById('order-form').addEventListener('submit', function(event) {
        var submitButton = document.getElementById('submit-button');
        // Disable the submit button to prevent multiple clicks
        submitButton.disabled = true;
        // Optionally, show a loading spinner or message
        submitButton.value = 'Submitting...';
    
    });
</script>
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

<script>
let counter = 0; // Initialize a counter outside of your event handler

$('.color').click(function() {
    counter++;
    const uniqueId = 'SKUS-' + counter;
    $('.good-card').append(
        '<div class="row" style="margin: auto;">' +
        '<div class="col-lg-12 form-label">' +
        '{{__("admin_message.product_name")}}' +
        '</div>' +
        '<div class="col-lg-4">' +
        '<select class="form-control SKUS select2 SKUS_append  ' + uniqueId +
        '" id="good_id" name="good_id[]" required>' +
        '<option value="">{{__("app.select", ["attribute" => __("admin_message.product_name")])}}</option>' +
        '@foreach ($goods as $data)<option  {{ $data->Client_packages_goods->sum("number") == 0 ? "disabled" : "" }}  value="{{$data->id}}">{{__("goods.instock")}} ({{$data->Client_packages_goods->sum("number")}})| {{$data->SKUS}}| {{$data->trans("title")}}</option>@endforeach'+

        '</select>' +
        '@error("good_id")' +
        '<span class="invalid-feedback text-danger" role="alert">' +
        '<strong>{{ $message }}</strong>' +
        '</span>' +
        '@enderror' +
        '</div>' +
        '<div class="col-lg-4">' +
        '<input class="form-control" type="number" step="1" min="1" name="number[]" placeholder="{{__("app.number")}}" />' +
        '@error("number")' +
        '<span class="invalid-feedback text-danger" role="alert">' +
        '<strong>{{ $message }}</strong>' +
        '</span>' +
        '@enderror' +
        '</div>' +
        '<div class="col-md-2"><button class="btn btn-danger remove-condition fa fa-x"></button></div>' +

        '</div>'
    );
    var urlclient_goods = $('#client_goods').attr("data-link") + '/' + $('.client_warehouse')
        .val() + '/' + '{{$lang}}';
    $('.' + uniqueId + 'option').remove();

    $.ajax({
        type: "GET",
        url: urlclient_goods,
        success: function(data) {
            for (var i = 0; i <= data.length; i++) {
                $('.' + uniqueId).append(data[i])



            }
        }
    });
    $(document).ready(function() {

        $('.select2').select2()
    });
});
</script>

<script>
$(document).ready(function() {
    // Use event delegation for dynamically generated content
    $(document).on('click', '.remove-condition', function() {
        // Find the closest parent div with class 'row' and remove it
        $(this).closest('div.row').remove();
    });
});
</script>



@endsection
