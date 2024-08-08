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
    {{-- @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.add'),
    'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false']) --}}

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
                    @endforeach
                </ul>
            </div>
            @endif -->
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
            <form action="{{route('client-orders.store')}}" method="POST">
                @csrf
                <div class="col-sm-6 invoice-col">
                    @lang('order.sender_name')
                    <address>
                        <!--  -->
                        <div class="form-group">
                            <label>@lang('order.store_name')</label>
                            @if(isset($clients))
                            <select class="form-control select2 client_warehouse" id="store_client_id" name="user_id"
                                required>
                                <option value="">@lang('app.select', ['attribute' => __('app.client')])</option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}} |
                                    {{$client->store_name}}
                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('app.address') }}</label>
                            <select class="form-control select2" id="sender_address" name="store_address_id" required>
                                <option  value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                            </select>
                            <!-- <input type="hidden" name="store_address_id" id="store_address_id"> -->
                        </div>

                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone" name="sender_phone" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <input type="text" class="form-control" name="sender_city" placeholder="City"
                                id="sender_city" readonly required>
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
                            <label>@lang('order.order_date')</label>
                            <input type="date" class="form-control" id="date" name="pickup_date" value=" "
                                placeholder="date" required>

                        </div>

                        <div class="form-group">
                            <label>@lang('app.No_pieces')</label>
                            <input type="number" class="form-control" min="1" value="1" name="number_count">
                        </div>
                        <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control" name="reference_number" value="">
                        </div>

                        <div class="form-group">
                            <label>@lang('app.weight')</label>
                            <input type="number" class="form-control" min="0" value="0" name="order_weight">
                        </div>

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @lang('app.to') (@lang('order.receiver'))
                    <address>
                        <div class="form-group">
                            <label>@lang('order.received_name', ['attribute' => ''])</label>
                            <input type="text" class="form-control" name="receved_name">
                            <!--  -->
                            @error('receved_name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" name="receved_phone"
                                placeholder="{{__('admin_message.phoneMessage')}}">
                            @error('receved_phone')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <select class="form-control select2" id="city_id" name="receved_city" required>
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}">{{$city->trans('title')}}</option>
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
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id">
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.neighborhood')])
                                </option>


                            </select>
                            @error('neighborhood_id')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address"
                                placeholder="@lang('app.detials', ['attribute' => __('app.address')])"></textarea>
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
                            <input type="number" class="form-control" min="0" step=".01" value="0" name="amount">
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
                            <label>{{__('admin_message.Notes')}} </label>
                            <textarea class="form-control" name="receved_notes"></textarea>
                            @error('Notes')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </address>
                </div>
                @if($work_type ==4)
                <div class="form-group row">
                    <div class="col-lg-12 form-label">
                        {{__('admin_message.product_name')}}
                    </div>
                    <div class="col-lg-4 ">
                        <select class="form-control  SKUS  select2" id="good_id" name="good_id[]" required>
                            <option class="" value="">@lang('app.select', ['attribute' =>
                                __('admin_message.product_name')])</option>
                          
                        </select>
                        @error('good_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-lg-4 ">
                        <input class="form-control" type="number" step="1" min="1" name="number[]"
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
                        <input type="submit" class="btn btn-success pull-right"
                            value="{{__('app.order', ['attribute' => __('app.add')])}}">

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
$(document).ready(function() {
    // Update hidden input when sender_address changes
    $('#sender_address').change(function() {
        var selectedOption = $(this).find('option:selected');
        $('#store_address_id').val(selectedOption.val());
    });

    // Initialize Select2
    $('.select2').select2();

    let counter2 = 0; // Initialize a counter outside of your event handler

    $('.color').click(function() {
        counter2++;
        const uniqueId = 'SKUS-' + counter2;
        $('.good-card').append(
            '<div class="row" style="margin: auto;">' +
            '<div class="col-lg-12 form-label">' +
            '{{__("admin_message.product_name")}}' +
            '</div>' +
            '<div class="col-lg-4">' +
            '<select class="form-control SKUS select2 SKUS_append ' + uniqueId +
            '" id="good_id" name="good_id[]" required>' +
            '<option value="">{{__("app.select", ["attribute" => __("admin_message.product_name")])}}</option>' +
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
        var urlclient_goods = '/client_goods_packages/' + $('.client_warehouse').val() + '/' + '{{$lang}}';
        $('.' + uniqueId + 'option').remove();

        $.ajax({
            type: "GET",
            url: urlclient_goods,
            success: function(data) {
                for (var i = 0; i <= data.length; i++) {
                    $('.' + uniqueId).append(data[i]);
                }
            }
        });
    });

    // Use event delegation for dynamically generated content
    $(document).on('click', '.remove-condition', function() {
        // Find the closest parent div with class 'row' and remove it
        $(this).closest('div.row').remove();
    });
});
</script>

<script src="{{asset('assets_web\js\packages.js')}}"></script>


@endsection