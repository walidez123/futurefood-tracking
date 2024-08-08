@extends('layouts.master')
@section('pageTitle', __('admin_message.Warehouse Branches'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_warehouse_branches', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => __('admin_message.Warehouse Branches'),
                'iconClass' => 'fa-map-marker',
                'addUrl' => route('warehouse_branches.create'),
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
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.city')</th>
                                        <th>@lang('app.longitude')</th>
                                        <th>@lang('app.latitude')</th>
                                        <th>@lang('app.area')</th>
                                        <th>{{ __('admin_message.Work Type') }}</th>

                                        <th>@lang('app.control')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($branches->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($branches->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($branches as $branch)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $branch->trans('title') }}</td>

                                            <td>
                                                {{ !empty($branch->city) ? $branch->city->trans('title') : '' }}
                                            </td>

                                            <th>{{ $branch->longitude }}</th>
                                            <th>{{ $branch->latitude }}</th>

                                            <td>{{ $branch->area }}</td>
                                            <td>
                                                @if ($branch->work == 1)
                                                    {{ __('admin_message.Warehouses') }}
                                                @elseif($branch->work == 2)
                                                    {{ __('fulfillment.fulfillment') }}
                                                @elseif($branch->work == 3)
                                                    {{ __('admin_message.Warehouses') }} &
                                                    {{ __('fulfillment.fulfillment') }}
                                                @endif


                                            </td>

                                            <td>
                                                @if (in_array('edit_warehouse_branches', $permissionsTitle))
                                                    <a href="{{ route('warehouse_branches.edit', $branch->id) }}"
                                                        title="Edit" class="btn btn-sm btn-primary"
                                                        style="margin: 2px;"><i class="fa fa-edit"></i> <span
                                                            class="hidden-xs hidden-sm">@lang('app.edit')</span></a>
                                                @endif
                                                <a href="{{ route('warehouse_areas.index', ['branch_id' => $branch->id]) }}"
                                                    title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                        class="fa fa-edit"></i> <span
                                                        class="hidden-xs hidden-sm">@lang('app.areas')</span></a>
                                                @if ($branch->work == 1 || $branch->work == 3)
                                                    <a href="{{ route('warehouse_stand.index', ['id' => $branch->id, 'type' => 'warehouses']) }}"
                                                        title="Edit" class="btn btn-sm btn-warning"
                                                        style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                            class="hidden-xs hidden-sm">@lang('app.stands')
                                                            {{ __('admin_message.Warehouses') }}</span></a>
                                                @endif
                                                @if ($branch->work == 2 || $branch->work == 3)
                                                    <a href="{{ route('warehouse_stand.index', ['id' => $branch->id, 'type' => 'fulfillment']) }}"
                                                        title="Edit" class="btn btn-sm btn-warning"
                                                        style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                            class="hidden-xs hidden-sm">@lang('app.stands')
                                                            {{ __('fulfillment.fulfillment') }}</span></a>
                                                @endif
                                                @if (in_array('delete_warehouse_branches', $permissionsTitle))
                                                    <form style="display: inline;"
                                                        action="{{ route('warehouse_branches.destroy', $branch->id) }}"
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
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.city')</th>
                                        <th>@lang('app.longitude')</th>
                                        <th>@lang('app.latitude')</th>
                                        <th>@lang('app.area')</th>
                                        <th>{{ __('admin_message.Work Type') }}</th>
                                        <th>@lang('app.control')</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <nav>
                                <ul class="pager">
                                    {{ $branches->appends($_GET)->links() }}
                                </ul>

                            </nav>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
