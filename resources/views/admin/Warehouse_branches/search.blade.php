@extends('layouts.master')
@section('pageTitle', 'orders')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <div class="row text-center" style="padding:12px">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('warehouse_branches.search') }}" method="GET">
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label for="to">{{ __('admin_message.Warehouse Branches') }}</label>
                                        <select id="warhouse_id" value="" class="form-control select2"
                                            name="warhouse_id">
                                            <option value="">{{ __('admin_message.Select') }}
                                                {{ __('admin_message.Warehouse Branches') }}</option>
                                            @foreach ($warehouse_branchs as $warhouse)
                                                <option
                                                    {{ isset($warehouse_branch) && $warehouse_branch == $warhouse->id ? 'selected' : '' }}
                                                    value="{{ $warhouse->id }}">{{ $warhouse->trans('title') }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group ">

                                        <label>@lang('admin_message.Search for palette')</label>
                                        <input type="text" name="package_title"
                                            placeholder="{{ __('admin_message.Enter the title of the pallet or shelf') }}"
                                            value="{{ isset($package_title) ? $package_title : '' }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group ">
                                        <label>@lang('admin_message.search')</label>
                                        <input type="submit" class="btn btn-block btn-primary" value="@lang('admin_message.filter')" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">

                            <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.warehouse')</th>
                                        <th>@lang('app.stands')</th>
                                        <th>@lang('app.floors')</th>
                                        <th>{{ __('admin_message.Work Type') }}</th>

                                        <th>@lang('admin_message.is_busy')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($warehouseContents))
                                        <?php
                                        if ($warehouseContents->currentPage() == 1) {
                                            $count = 1;
                                        } else {
                                            $count = ($warehouseContents->currentPage() - 1) * 25 + 1;
                                        }
                                        ?>

                                        @foreach ($warehouseContents as $warehouseContent)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{ $warehouseContent->title }}</td>
                                                <th>{{ $warehouseContent->warehouse->trans('title') }}</th>
                                                <th>{{ $warehouseContent->stand->title }}</th>
                                                <th>{{ $warehouseContent->floor->title }}</th>
                                                <td>
                                                    @if ($warehouseContent->work == 1)
                                                        {{ __('admin_message.Warehouses') }}
                                                    @elseif($warehouseContent->work == 2)
                                                        {{ __('fulfillment.fulfillment') }}
                                                    @elseif($branch->work == 3)
                                                        {{ __('admin_message.Warehouses') }} &
                                                        {{ __('fulfillment.fulfillment') }}
                                                    @endif
                                                </td>
                                                <th>
                                                    @if ($warehouseContent->is_busy == 1)
                                                        {{ __('admin_message.Yes') }}
                                                    @else
                                                        {{ __('admin_message.No') }}
                                                    @endif

                                                </th>
                                                <th>
                                                    @if($warehouseContent->is_busy==1)
                                                    <a href="{{route('warehouse_branches.search_details',['id'=>$warehouseContent->id])}}" target="_blank" rel="noopener noreferrer">{{__('admin_message.details')}}</a>

                                                    @endif
                                                </th>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.warehouse')</th>
                                        <th>@lang('app.stands')</th>
                                        <th>@lang('app.floors')</th>
                                        <th>{{ __('admin_message.Work Type') }}</th>

                                        <th>@lang('admin_message.is_busy')</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                        @if (isset($warehouseContents))
                            <nav>
                                <ul class="pager">
                                    {{ $warehouseContents->appends($_GET)->links() }}
                                </ul>

                            </nav>
                        @endif

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
