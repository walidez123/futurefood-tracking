@extends('layouts.master')
@section('pageTitle', __('app.order', ['attribute' => '']))
@section('css')
<link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', [
    'title' => __('app.damaged_goods', ['attribute' => '']),
    'type' => __('app.add'),
    'iconClass' => 'fa-truck',
    'url' => route('damaged-goods.index'),
    'multiLang' => 'false',
    ])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>@lang('app.add') @lang('app.damaged_goods', ['attribute' => ''])
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
            <form action="{{ route('damaged-goods.store') }}" method="POST">
                @csrf
                <input type="hidden" name="lang" id="lang" value="{{ App::getLocale() }}">

                <div class="col-sm-6 col-md-6 invoice-col">
                    <address>
                        <!--  -->
                        <div class="form-group">
                            <label>@lang('order.store_name')</label>
                            @if (isset($clients))
                            <select class="form-control select2 client_warehouse" id="" name="client_id" required>
                                <option value="">@lang('app.select', ['attribute' => __('app.client')])</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" data-store_address_id="" data-region="" data-city=""
                                    data-address1="" data-address2="" data-phone="">
                                    {{ $client->name }} | {{ $client->store_name }}
                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-md-6 invoice-col">
                    <address>
                        <!--  -->
                        <div class="form-group">
                            <label for="goods" class="control-label">
                                {{ __('admin_message.Warehouse Branches') }}</label>
                            <div class="">
                                <select required id="warhouse_id" class="form-control select2"
                                    name="warehouse_branche_id">
                                    <option value="">{{ __('admin_message.Select') }}
                                        {{ __('admin_message.Warehouse Branches') }}</option>
                                    @foreach ($warehouseBranches as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->trans('title') }}</option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </address>
                </div>
                <div class="col-lg-1 form-label">
                    {{ __('goods.Goods') }}
                </div>
                <div class="form-group col-sm-12 col-md-12 invoice-col">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">@lang('goods.skus')</label>
                            <select required class="form-control SKUS qr-result select2" name="good_id[]" id="SKUS"
                                placeholder="">
                                <option value="">{{ __('admin_message.Select') }} @lang('goods.skus')
                                </option>
                            </select>
                            @error('SKUS')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-md-3">
                        <div class="form-group">

                            <label for="name"> @lang('app.Shelf') </label>
                            <select required class="form-control select2 package_title" name="warehouse_content_id[]"
                                id="" placeholder="">
                                <option value="">{{ __('admin_message.Select') }}

                                    @lang('app.Shelf')
                                </option>
                            </select>
                            <!-- <button id="scanButton-package_title">Scan code</button> -->
                            @error('package_title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label>{{ __('admin_message.Select') }} {{ __('app.goods_statuses') }}</label>
                        <select required id="status_id" class="form-control select2" name="goods_status_id[]">
                            <option value="">{{ __('admin_message.Select') }} {{ __('app.goods_statuses') }}</option>
                            @foreach ($goodsStatuses as $status)
                            <option value="{{ $status->id }}">
                                {{ $status->trans('name') }}
                            </option>
                            @endforeach
                        </select>
                        @error('status_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2">
                        <label>@lang('app.number')</label>
                        <input required class="form-control" type="number" name="number[]"
                            placeholder='{{ __("app.number") }}' />
                        @error('number')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-1">
                        <button class=" btn-info package_plus" type="button"> <i class="fa fa-solid fa-plus"></i></button>
                    </div>                
                </div>
                                
                <div class="new_row">
                </div>

                <div class="row no-print">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right "
                            value="{{ __('app.add', ['attribute' => __('app.add')]) }}">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var label;

label = "{{ __('app.Shelf') }}";
var status = "{{ __('admin_message.Select') }} {{ __('app.goods_statuses') }}";
var number = "{{ __('admin_message.number') }}";
var skus = "{{ __('goods.skus') }}";
var goodsStatuses = [
    {
        value: 0,
        text: '{{ __('admin_message.Select') }} {{ __('app.goods_statuses') }}'
    },
    @foreach($goodsStatuses as $status)
    {
        value: {{ $status->id }},
        text: '{{ $status->trans('name') }}'
    },
    @endforeach
];

</script>
<script src="{{ asset('assets_web\js\Damaged.js') }}"></script>
@endsection