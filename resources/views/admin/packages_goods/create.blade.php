@extends('layouts.master')
@section('pageTitle', __('admin_message.Packaging goods/cartons'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => __('admin_message.Packaging goods/cartons'),
            'type' => '',
            'iconClass' => 'fa-print',
            'url' => route('goods.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!--  -->

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!--  -->
                <form action="{{ route('packages_goods.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="work" value="{{ $type }}">


                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('admin_message.Packaging goods/cartons') }}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="goods"
                                        class="control-label">{{ __('admin_message.Warehouse Clients') }}</label>
                                    <div class="">
                                        <select required value="" class="form-control select2 client_warehouse"
                                            name="client_id">
                                            <option value=""> {{ __('admin_message.Select') }}
                                                {{ __('admin_message.Warehouse Clients') }}</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group ">
                                    <label for="goods" class="control-label">
                                        {{ __('admin_message.Warehouse Branches') }}</label>
                                    <div class="">
                                        <select required id="warhouse_id" value="" class="form-control select2"
                                            name="warhouse_id">
                                            <option value="">{{ __('admin_message.Select') }}
                                                {{ __('admin_message.Warehouse Branches') }}</option>
                                            @foreach ($warehouse_branchs as $warhouse)
                                                <option value="{{ $warhouse->id }}">{{ $warhouse->trans('title') }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('warhouse_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- total area & space area -->
                            <div class="show" style="display: none !important;">
                                @if ($type == 1)
                                    <div class="col-md-6">
                                        <div class=" form-group ">
                                            <label for="goods"
                                                class="control-label">{{ __('admin_message.Total customer area') }}:</label>

                                            <div style="display: inline;" class="total_area"> </div>



                                        </div>
                                    </div>
                                @endif

                                @if ($type == 1)
                                    <div class="col-md-6">
                                        <div class=" form-group ">
                                            <label for="goods" class="control-label">
                                                {{ __('admin_message.free area') }}
                                                :</label>
                                            <div style="display: inline;" class="unbusy_area"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- تسكين المنتج للطبلية -->
                                <div class="col-md-12">
                                    <h3> {{ __('admin_message.Packaging goods/cartons') }}</h3>
                                </div>

                                <div class="row" style="margin: auto;">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">@lang('goods.skus')</label>
                                            <select required class="form-control SKUS qr-result select2" name="SKUS[]"
                                                id="SKUS" placeholder="">
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
                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="name">@lang('admin_message.number')</label>
                                            <input required type="number" class="form-control " value="1"
                                                name="number[]" id="" placeholder="">

                                            @error('number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="name">@lang('admin_message.Expiration date')</label>
                                            <input type="date" class="form-control " name="expiration_date[]"
                                                id="" placeholder="">

                                            @error('expiration_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            @if ($type == 1)
                                                <label for="name"> @lang('app.packages') </label>
                                            @else
                                                <label for="name"> @lang('app.Shelf') </label>
                                            @endif
                                            <select required class="form-control select2 package_title"
                                                name="package_title[]" id="" placeholder="">
                                                <option value="">{{ __('admin_message.Select') }}
                                                    @if ($type == 1)
                                                        @lang('app.packages')
                                                    @else
                                                        @lang('app.Shelf')
                                                    @endif
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
                                    <div class="col-md-2">
                                        <button class=" btn-info package_plus" type="button"> <i
                                                class="fa fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                                <div class="new_row">
                                </div>
                                <div class="col-md-12">
                                    <h3> {{ __('admin_message.total') }}</h3>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="name"> {{ __('admin_message.total') }} {{ __('goods.Goods') }}
                                            :</label>
                                        <div id="totalSKUS">{{ __('admin_message.total') }} {{ __('goods.Goods') }}
                                            {{ __('admin_message.different') }} : 0</div>

                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="name">{{ __('admin_message.total') }} @if ($type == 1)
                                                <label for="name"> @lang('app.packages') </label>
                                            @else
                                                <label for="name"> @lang('app.Shelves') </label>
                                            @endif :</label>
                                        <div id="totalPackages"> <label for="name">{{ __('admin_message.total') }}
                                                @if ($type == 1)
                                                    @lang('app.packages')
                                                @else
                                                    @lang('app.Shelves')
                                                @endif {{ __('admin_message.different') }}: 0</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" footer">
                        @if ($type == 1)
                            <button type="submit" class="btn btn-primary free">{{ __('admin_message.save') }} </button>
                        @else
                            <button type="submit" class="btn btn-primary ">{{ __('admin_message.save') }} </button>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        var $type = <?php echo $type; ?>;
        var label;
        if ($type == 1) {
            label = "{{ __('app.packages') }}";
        } else {
            label = "{{ __('app.Shelf') }}";
        }
        var Expiration = "{{ __('admin_message.Expiration date') }}";
        var number = "{{ __('admin_message.number') }}";
        var skus = "{{ __('goods.skus') }}";
    </script>
    <script src="{{ asset('assets_web\js\packages.js') }}"></script>
@endsection
