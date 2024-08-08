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
    @include('layouts._header-form', ['title' => __('app.orderspickup', ['attribute' => '']), 'type' => __('app.edit'),
    'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>@lang('app.edit') @lang('app.orderspickup', ['attribute' => ''])
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
            <form action="{{route('client_orders_pickup.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-6 col-md-6   invoice-col">
                    <address>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.select', ['attribute' =>
                                __('app.address')])</label>
                            <select required class="form-control" id="sender_address" name="sender_city">
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @foreach ($addresses as $address)
                                <option {{($order->store_address_id == $address->id) ? 'selected' : ''}}
                                    value="{{! empty( $address->city ) ? $address->city->id : '' }}"
                                    data-store_address_id="{{$address->id}}"
                                    data-region="{{! empty( $address->neighborhood ) ? $address->neighborhood->title : '' }}"
                                    data-city="{{! empty( $address->city ) ? $address->city->trans('title') : '' }}"
                                    data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                    data-phone="{{$address->phone}}">{{$address->address}}
                                    |{{! empty( $address->city ) ? $address->city->trans('title') : $address->description }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="store_address_id" id="store_address_id">


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



                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6  col-md-6  invoice-col">
                    <address>
                        <!--  -->
                        <div class=" form-group ">
                            <label for="goods" class="control-label"> {{__('admin_message.Warehouse Branches')}}</label>
                            <div class="">
                                <select required id="warhouse_id" value="" class="form-control select2"
                                    name="warehouse_id">
                                    <option value="">{{__('admin_message.Select')}}
                                        {{__('admin_message.Warehouse Branches')}}</option>
                                    @foreach ($Warehouse_branches as $warhouse)
                                    <option {{($order->warehouse_id == $warhouse->id) ? 'selected' : ''}}
                                        value="{{$warhouse->id}}">{{$warhouse->trans('title')}}</option>
                                    @endforeach

                                </select>
                                @error('warhouse_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class=" form-group ">
                            <label for="goods" class="control-label"> {{__('admin_message.Storage types')}}</label>
                            <div class="">
                                <select required id="storage_types" value="" class="form-control select2"
                                    name="storage_types">
                                    <option value="">{{__('admin_message.Select')}}
                                        {{__('admin_message.Storage types')}}</option>
                                    <option {{($order->storage_types == 1) ? 'selected' : ''}} value="1">
                                        {{__('admin_message.pallet')}}</option>
                                    <option {{($order->storage_types == 2) ? 'selected' : ''}} value="2">
                                        {{__('admin_message.Carton')}}</option>


                                </select>
                                @error('storage_types')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- show if cartoun -->
                        <div class=" form-group ">
                            <label for="goods" class="control-label"> {{__('admin_message.Sizes')}}</label>
                            <div class="">
                                <select id="size_id" value="" class="form-control select2" name="size_id">
                                    <option value="">{{__('admin_message.Select')}}
                                        {{__('admin_message.Sizes')}}</option>
                                    @foreach($sizes as $size)
                                    <option {{($order->size_id == $size->id) ? 'selected' : ''}} value="{{$size->id}}">
                                        {{$size->trans('name')}}</option>
                                    @endforeach


                                </select>
                                @error('size_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- delevery   -->
                        <div class=" form-group ">
                            <label for="goods" class="control-label"> {{__('admin_message.Delivery Service')}}</label>
                            <div class="">
                                <select id="delivery_service" value="" class="form-control select2"
                                    name="delivery_service">

                                    <option {{($order->delivery_service == 0) ? 'selected' : ''}} value="0">
                                        {{__('admin_message.No')}}</option>
                                    <option {{($order->delivery_service == 1) ? 'selected' : ''}} value="1">
                                        {{__('admin_message.Yes')}}</option>



                                </select>
                                @error('delivery_service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>




                        <!--  -->
                    </address>
                </div>
                <!--  -->
                <div class="form-group col-sm-12 col-md-12  invoice-col ">

                    @if($order->pickup_orders_good && count($order->pickup_orders_good) > 0)
                    <div class="row">
                        <h3>{{__('goods.Goods')}}</h3>


                        <table class="table table-bordered table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th>{{__('goods.Goods')}}</th>
                                    <th>@lang('admin_message.Expiration date')</th>
                                    <th>{{__("app.number")}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;$date = now()->format('Y-m-d');?>
                                @foreach ($order->pickup_orders_good as $i=>$good)
                                <tr>
                                    <th>{{!empty( $good->good) ? $good->good->trans('title') : ''}}|
                                                {{!empty( $good->good) ? $good->good->SKUS : ''}}</th>
                                    <th>{{$good->expiration_date}}</th>
                                    <th>{{$good->number}}</th>
                                    <th> 
                                    <!--  -->
                                    @if(($order->work_type==3 &&  in_array('delete_pickup_order_warehouse', $permissionsTitle))  || ($order->work_type==4 &&  in_array('delete_pickup_order_fulfillment', $permissionsTitle)))

                                    <a href="{{route('client_orders_pickup_good.destroy', $good->id)}}" title="View" class="btn btn-sm btn-danger"
                                       style="margin: 2px;"><i class="fa fa-trash"></i> <span class="hidden-xs hidden-sm">@lang('admin_message.Delete')</span> </a>
                                    @endif
                                        
                                </th>



                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    @endif
                </div>



                <!--  -->




                <div class="form-group col-sm-12 col-md-12  invoice-col ">
                    <div class="col-lg-1 form-label">
                        {{__('goods.Goods')}}
                    </div>
                    <div class="col-lg-3 ">
                        <label>{{__('admin_message.Select')}} {{__('goods.Goods')}}</label>
                        <select  id="product_name" value="" class="form-control select2" name="good_id[]">
                            <option value="">{{__('admin_message.Select')}}
                                {{__('goods.Goods')}}</option>
                            @foreach($goods as $good)
                            <option value="{{$good->id}}">{{$good->trans('title')}} | {{$good->SKUS}}</option>
                            @endforeach


                        </select>
                        @error('product_name')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 ">
                        <label>@lang('admin_message.Expiration date')</label>
                        <input type="date" class="form-control" name="expiration_date[]" >
                        @error('expiration_date')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2 ">
                        <label>@lang('app.number')</label>

                        <input  class="form-control" type="number" name="number[]"
                            placeholder='{{__("app.number")}}' />
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
                    <button class=" btn-info add_goods" type="button"> <i class="fa fa-solid fa-plus"></i></button>
                </div>
                <br>


                <div class="row no-print">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right"
                            value="{{__('app.order', ['attribute' => __('app.add')])}}">

                    </div>
                </div>
            </form>
            <!-- /.row -->
    </section>
</div>



<!-- this row will not appear when printing -->

</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(document).ready(() => {
    var selected = $("#sender_address").find('option:selected');
    var phone = selected.data('phone');
    var city = selected.data('city');
    var region = selected.data('region');
    var store_address_id = selected.data('store_address_id');

    var address_1 = selected.data('address1');
    var address_2 = selected.data('address2');
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
    var store_address_id = selected.data('store_address_id');

    var address_1 = selected.data('address1');
    var address_2 = selected.data('address2');

    $('#sender_phone').val(phone);
    $('#sender_city').val(city);
    $('#sender_region').val(region);
    $('#store_address_id').val(store_address_id);


    $('#sender_address1').val(address_1);
    $('#sender_address_2').val(address_2);

});
</script>
<script>
$(document).ready(function() {

    $('.add_goods').click(function() {
        // Removed the dd("d"); assuming it was for debugging

        $('.cardiv').append(`
        <div class='row'>
            <div class='col-lg-1 form-label'>{{ __('goods.Goods') }}</div>
            <div class='col-lg-3'>
                <label>{{ __('admin_message.Select') }} {{ __('goods.Goods') }}</label>
                <select required class='form-control select2' name='good_id[]'>
                    <option value=''>{{ __('admin_message.Select') }}{{ __('goods.Goods') }}</option>
                    @foreach($goods as $good)
                        <option value='{{ $good->id }}'>{{ $good->trans('title') }} | {{ $good->SKUS }}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-lg-3 '>
                <label>{{ __('admin_message.Expiration date') }}</label>
                <input class='form-control' type='date' name='expiration_date[]' />
            </div>
            <div class='col-lg-2 '>
                <label>{{ __('app.number') }}</label>
                <input class='form-control' type='text' name='number[]' placeholder='{{ __('app.number') }}'/>
            </div>
        </div>
        <br>`);
    });
});
</script>
@endsection