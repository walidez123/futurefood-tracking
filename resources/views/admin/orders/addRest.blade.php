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
            <form action="{{route('client-orders.store')}}" method="POST">
                <input type="hidden" name="lang" id="lang" value="{{ App::getLocale() }}">
                @csrf
                <div class="col-sm-6 invoice-col">
                    @lang('order.sender_name')
                    <address>
                        <div class="form-group">
                            <label>{{ __('order.restaurant_name') }}</label>
                            @if(isset($clients))
                            <select class="form-control select2" id="store_client_id" name="user_id" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.client')])</option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}} | {{$client->store_name}}
                                </option>
                                @endforeach
                            </select>
                            @endif


                        </div>
                        <div class="form-group">
                            <label>{{ __('app.address') }}</label>
                            <select class="form-control select2" id="sender_address" name="store_address_id" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone" name="sender_phone" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <input type="text" class="form-control" placeholder="{{__('admin_message.City')}}"
                                id="sender_city" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.neighborhood')</label>
                            <input type="text" class="form-control" placeholder="{{__('app.neighborhood')}}"
                                id="sender_region" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.address')</label>
                            <input type="text" class="form-control" placeholder="{{__('app.neighborhood')}}"
                                id="sender_address1" name="sender_address" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label>{{__('app.amount_paid')}} </label>
                            <select class="form-control select2" id="amount_paid" name="amount_paid" required>
                                <option value="0">{{__('admin_message.UnPaid')}}</option>
                                <option value="1"> {{__('admin_message.Paid')}}</option>
                            </select>
                            @error('amount_paid')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control" name="reference_number" value="">
                            @error('reference_number')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @lang('app.to') (@lang('order.receiver'))
                    <address>
                        <div class="form-group">
                            <label>@lang('order.received_name', ['attribute' => ''])</label>
                            <input type="text" class="form-control" name="receved_name" required>
                            @error('receved_name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input required type="text" class="form-control" name="receved_phone"
                                placeholder="{{__('admin_message.phoneMessage')}}">
                            @error('receved_phone')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <select class="form-control select2" id="city_id" name="receved_city" >
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
                            <select class="form-control select2" id="neighborhood_id" name="neighborhood_id" >
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.region')])
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
                            <textarea  class="form-control " name="receved_address"
                                placeholder="@lang('app.detials', ['attribute' => __('app.address')])"></textarea>
                            @error('receved_address')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input type="number" class="form-control" min="0" step=".01" value="0" name="amount" required>
                            @error('amount')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @include('partial.address_option')


                    </address>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2 form-label">
                        <label>{{__('admin_message.product_name')}} <br></label>

                        
                    </div>
                    <div class="col-lg-2 ">
                        <input  class="form-control" type="text" name="product_name[]"
                            placeholder="{{__('admin_message.product_name')}}" />
                        @error('product_name')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2 ">
                        <input  class="form-control" type="text" name="size[]"
                            placeholder='{{__("app.size")}}' />
                        @error('size')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2 ">
                        <input  class="form-control" type="number" name="number[]"
                            placeholder='{{__("app.No_pieces")}}' />
                        @error('number')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <br>
                </div>

                <div class="cardiv form-group row">
                </div>
                <div style="float: left;" class="col-lg-2 ">
                    <button class=" btn-info color" type="button"> <i class="fa fa-solid fa-plus"></i></button>
                </div>
                <br>


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
<script type="text/javascript">
    // Define global variables here
    var translations = {
        product_name: "{{__('app.product name')}}",
        size: "{{__('app.size')}}",
        number: "{{__('app.No_pieces')}}"

    };

</script>
<script src="{{ asset('assets_web/js/restaurant_order.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_maps.key')}}&language=ar"></script>
<script type="text/javascript" src="{{asset('assets/bower_components/admin/address_options.js')}}"></script>  
<script type="text/javascript" src="{{asset('assets/bower_components/admin/show_map.js')}}"></script> 
@endsection