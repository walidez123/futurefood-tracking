@extends('layouts.master')
@section('pageTitle', __('admin_message.Packaging goods/cartons'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_packaging_goods', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => __('admin_message.Packaging goods/cartons'),
                'iconClass' => 'fa-map-marker',
                'addUrl' => route('packages_goods.create', ['type' => $type]),
                'multiLang' => 'false',
            ])
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin_message.Client name')</th>
                                        <th>@lang('admin_message.Warehouse Name')</th>
                                        <th>@lang('goods.Goods')</th>
                                        <th>@lang('admin_message.number')</th>

                                        <th>@lang('admin_message.Expiration date')</th>

                                        @if ($type == 1)
                                            <th>@lang('app.packages')</th>
                                        @else
                                            <th>@lang('app.Shelves')</th>
                                        @endif

                                        <th>@lang('app.control')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($client_packages_goods->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($client_packages_goods->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($client_packages_goods as $client_packages_good)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td> {{ !empty($client_packages_good->client) ? $client_packages_good->client->name : '' }}</td>

                                            <td>{{ $client_packages_good->warehouse->trans('title') }}</td>

                                            <th>{{!empty( $client_packages_good->good) ? $client_packages_good->good->trans('title') : ''}}</th>
                                            <th>{{ $client_packages_good->number }}</th>
                                            <th>{{ $client_packages_good->expiration_date }}</th>

                                            <th>{{ $client_packages_good->package->title }}</th>



                                            <td>
                                                @if (in_array('show_packaging_goods', $permissionsTitle))
                                                    <a href="{{ route('packages_goods.show', $client_packages_good->id) }}"
                                                        title="View" class="btn btn-sm btn-warning"
                                                        style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                            class="hidden-xs hidden-sm">{{ __('admin_message.details') }}</span>
                                                    </a>
                                                @endif


                                                @if (in_array('delete_packaging_goods', $permissionsTitle))
                                                    <form style="display: inline;"
                                                        action="{{ route('packages_goods.destroy', $client_packages_good->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Do you want Delete This Record ?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            @lang('app.delete')
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin_message.Client name')</th>
                                        <th>@lang('admin_message.Warehouse Name')</th>
                                        <th>@lang('goods.Goods')</th>
                                        <th>@lang('admin_message.number')</th>
                                        <th>@lang('admin_message.Expiration date')</th>
                                        @if ($type == 1)
                                            <th>@lang('app.packages')</th>
                                        @else
                                            <th>@lang('app.Shelves')</th>
                                        @endif

                                        <th>@lang('app.control')</th>

                                    </tr>
                                </tfoot>
                            </table>

                        </div><!-- /.box-body -->
                        {{ $client_packages_goods->appends(Request::query())->links() }}

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
