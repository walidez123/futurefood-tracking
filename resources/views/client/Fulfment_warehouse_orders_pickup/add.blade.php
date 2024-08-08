@extends('layouts.master')
@section('pageTitle', __('app.order', ['attribute' => '']))
@section('css')
<link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', [
    'title' => __('app.orderspickup', ['attribute' => '']),
    'type' => __('app.add'),
    'iconClass' => 'fa-truck',
    'url' => route('orders.index'),
    'multiLang' => 'false',
    ])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>@lang('app.add') @lang('app.orderspickup', ['attribute' => ''])
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
            <form action="{{ route('orders_pickup.store') }}" method="POST">
                @csrf
                <input type="hidden" name="lang" id="lang" value="{{ App::getLocale() }}">
                @csrf
                <div class="col-sm-6 col-md-6   invoice-col">
                    <address>
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('app.select', ['attribute' =>
                                __('app.address')])</label>
                            <select required class="form-control" id="sender_address" name="store_address_id">
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @foreach ($addresses as $address)
                                <option {{ $address->main_address == 1 ? 'selected' : '' }} value="{{ $address->id }}"
                                    data-store_address_id="{{ $address->id }}"
                                    data-region="{{ !empty($address->neighborhood) ? $address->neighborhood->title : '' }}"
                                    data-city="{{ !empty($address->city) ? $address->city->trans('title') : '' }}"
                                    data-address1="{{ $address->address }}" data-address2="{{ $address->description }}"
                                    data-phone="{{ $address->phone }}">{{ $address->address }}
                                    |{{ !empty($address->city) ? $address->city->trans('title') : $address->description }}
                                </option>
                                @endforeach
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
                            <input type="text" class="form-control" name="sender_city"
                                placeholder="{{ __('admin_message.City') }}" id="sender_city" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.neighborhood')</label>
                            <input type="text" class="form-control" placeholder="{{ __('app.neighborhood') }}"
                                id="sender_region" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.address')</label>
                            <input type="text" class="form-control" placeholder="{{ __('app.neighborhood') }}"
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
                            <label for="goods" class="control-label">
                                {{ __('admin_message.Warehouse Branches') }}</label>
                            <div class="">
                                <select required id="warhouse_id" value="" class="form-control select2"
                                    name="warehouse_id">
                                    <option value="">{{ __('admin_message.Select') }}
                                        {{ __('admin_message.Warehouse Branches') }}</option>
                                    @foreach ($Warehouse_branches as $warhouse)
                                    <option value="{{ $warhouse->id }}">{{ $warhouse->trans('title') }}</option>
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
                            <label for="goods" class="control-label">
                                {{ __('admin_message.Storage types') }}</label>
                            <div class="">
                                <select required id="storage_types" value="" class="form-control select2"
                                    name="storage_types">
                                    <option value="">{{ __('admin_message.Select') }}
                                        {{ __('admin_message.Storage types') }}</option>
                                    <option value="1">{{ __('admin_message.tablia') }}</option>
                                    <option value="2">{{ __('admin_message.Carton') }}</option>


                                </select>
                                @error('storage_types')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- show if cartoun -->
                        <div class=" form-group" id="sizes">
                            <label for="goods" class="control-label"> {{ __('admin_message.Sizes') }}</label>
                            <div class="">
                                <select id="size_id" value="" class="form-control select2" name="size_id">
                                    <option value="">{{ __('admin_message.Select') }}
                                        {{ __('admin_message.Sizes') }}</option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->trans('name') }}</option>
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
                        <div class=" form-group" id="delivery_service">
                            <label for="goods" class="control-label">
                                {{ __('admin_message.Delivery Service') }}</label>
                            <div class="">
                                <select  value="" class="form-control select2"
                                    name="delivery_service">
                                    <option value="0">{{ __('admin_message.No') }}</option>
                                    <option value="1">{{ __('admin_message.Yes') }}</option>
                                </select>
                                @error('delivery_service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" form-group" id="pallete_number_container">
                            <label>@lang('app.pallete_number')</label>
    
                            <input required class="form-control" type="number" name="pallete_number"
                                placeholder='{{ __('app.pallete_number') }}' />
                            @error('pallete_number')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </address>
                </div>
                <div class="form-group col-sm-12 col-md-12  invoice-col ">
                    <div class="col-lg-1 form-label">
                        {{ __('goods.Goods') }}
                    </div>
                    <div class="col-lg-3 ">
                        <label>{{ __('admin_message.Select') }} {{ __('goods.Goods') }}</label>
                        <select required id="goodsSelect" class="form-control select2" name="good_id[]">
                            <option value="">{{ __('admin_message.Select') }} {{ __('goods.Goods') }}</option>
                            @foreach ($goods as $i=>$good)
                            <option value="{{ $good->id }}" data-expiration-date="{{ $good->has_expire_date }}">
                                {{ $good->trans('title') }} | {{ $good->SKUS }}
                            </option>
                            @endforeach
                        </select>
                        @error('good_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 " id="add_expiration_date">
                        <label>@lang('admin_message.Expiration date')</label>
                        <input type="date" id="expirationDateInput" class="form-control" name="expiration_date[]" disabled>
                        @error('expiration_date')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2 ">
                        <label>@lang('app.number')</label>

                        <input required class="form-control" type="number" name="number[]"
                            placeholder='{{ __('app.number') }}' />
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
                            value="{{ __('app.order', ['attribute' => __('app.add')]) }}">

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
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const goodsSelect = document.getElementById('goodsSelect');
        const expirationDateInput = document.getElementById('expirationDateInput');

        goodsSelect.addEventListener('change', function () {
            const selectedOption = goodsSelect.options[goodsSelect.selectedIndex];
            const hasExpireDate = selectedOption.getAttribute('data-expiration-date') === '1';

            expirationDateInput.disabled = !hasExpireDate;
        });
    });
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let counter = 0;
    $('.add_goods').click(function() {
        counter++;
        const uniqueId = 'SKUS-' + counter;
        const expireDateId = 'expiredate-' + counter;
        $('.cardiv').append(`
        <div class='row'>
            <div class='col-lg-1 form-label'>{{ __('goods.Goods') }}</div>
            <div class='col-lg-3'>
                <label>{{ __('admin_message.Select') }} {{ __('goods.Goods') }}</label>
                <select required class='form-control select2 ${uniqueId}' name='good_id[]'>
                    <option value=''>{{ __('admin_message.Select') }}{{ __('goods.Goods') }}</option>
                    @foreach ($goods as $good)
                        <option data-expiration-date="{{ $good->has_expire_date }}" value='{{ $good->id }}'>{{ $good->trans('title') }} | {{ $good->SKUS }}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-lg-3 '>
                <label>{{ __('admin_message.Expiration date') }}</label>
                <input class='form-control ${expireDateId}' type='date' name='expiration_date[]' />
            </div>
            <div class='col-lg-2 '>
                <label>{{ __('app.number') }}</label>
                <input class='form-control' type='text' name='number[]' placeholder='{{ __('app.number') }}'/>
            </div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-condition"><i class="fa fa-times"></i></button></div>
        </div>
        <br>`);
        $(`.${uniqueId}`).change(function() {
            const expirationDateAttr = $(this).find(':selected').data('expiration-date');
            const expireDateInput = $(this).closest('.row').find(`.${expireDateId}`);
            if (expirationDateAttr ===
                1) { // Make sure the comparison is done correctly based on the data type
                expireDateInput.prop('disabled', false);
            } else {
                expireDateInput.prop('disabled', true).val('');
            }
        });
        $('.' + uniqueId).select2();

    });
});


$(document).on('click', '.remove-condition', function() {
    $(this).closest('.row').remove();
});

</script>
<script>
    $(document).ready(function() {
    $('#sizes').hide();

    $('#storage_types').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue === '2') {
            $('#sizes').show();
        } else {
            $('#sizes').hide();
        }
    });
});
</script>

@endsection