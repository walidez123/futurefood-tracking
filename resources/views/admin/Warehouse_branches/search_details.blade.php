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
                           

                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                        
                            <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('goods.product_name')</th>
                                        <th>@lang('admin_message.number')</th>
                                        <th>@lang('app.Shelf_num')</th>
                                        <th>@lang('goods.date')</th>
                                        <th>@lang('goods.expire_date')</th>
                                        <th>@lang('app.control')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($packages_goods))
                                        <?php
                                        if ($packages_goods->currentPage() == 1) {
                                            $count = 1;
                                        } else {
                                            $count = ($packages_goods->currentPage() - 1) * 25 + 1;
                                        }
                                        ?>
                                        @foreach ($packages_goods as $single_good)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{!empty( $single_good->good) ? $single_good->good->trans('title') : ''}}|  {{!empty( $single_good->good) ? $single_good->good->SKUS : ''}}</td>
                                                <th>{{ $single_good->number }}</th>
                                                <th>{{ $single_good->package->title }}</th>
                                                <td>{{ \Carbon\Carbon::parse($single_good->created_at)->format('Y-m-d') }}
                                                </td>
                                                <td>

                                                    @if ($single_good->expiration_date != null)
                                                        <span style="color: red;">
                                                            {{ $single_good->expiration_date ? $single_good->expiration_date : '' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (in_array('show_packaging_goods', $permissionsTitle))
                                                        <a href="{{ route('packages_goods.show', $single_good->id) }}"
                                                            title="View" class="btn btn-sm btn-warning"
                                                            style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                                class="hidden-xs hidden-sm">{{ __('admin_message.details') }}</span>
                                                        </a>
                                                    @endif
                                                </td>

                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('goods.product_name')</th>
                                        <th>@lang('admin_message.number')</th>
                                        <th>@lang('app.Shelf_num')</th>
                                        <th>@lang('goods.date')</th>
                                        <th>@lang('goods.expire_date')</th>
                                        <th>@lang('app.control')</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                        @if (isset($packages_goods))
                            {!! $packages_goods->appends($_GET)->links() !!}
                        @endif
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
