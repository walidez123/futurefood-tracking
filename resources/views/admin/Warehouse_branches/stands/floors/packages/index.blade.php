@extends('layouts.master')
@if (isset($stand_id))
    @if ($stand_id->work == 1)
    @endif
    @section('pageTitle', __('app.packages'))
@else
    @section('pageTitle', __('app.Shelves'))
@endif
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @if (isset($stand_id))
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">

                @if ($stand_id->work == 1)
                    @lang('app.add') @lang('app.packages')
                @else
                    @lang('app.add') @lang('app.Shelves')
                @endif
        @endif
        </button>
        @if (isset($stand_id))

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-body">
                            <form action="{{ route('warehouse_package.store') }}" method="post" class="col-xs-12">
                                @csrf

                                <input type="hidden" name="floor_id" value="{{ $stand_id->id }}">

                                <div class="col-lg-12">
                                    <label>
                                        @if ($stand_id->work == 1)
                                            @lang('app.package number')
                                        @else
                                            @lang('app.Shelves number')
                                        @endif
                                    </label>
                                    <input type="number" name="number" class="form-control" value="1" id="">
                                </div>
                        </div>
                        <div class="modal-footer">

                            <div class="col-lg-6">
                                <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                    value="{{ __('admin_message.save') }}" />
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-block btn-secondary "
                                    data-dismiss="modal">{{ __('admin_message.close') }}</button>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>

        @endif

        <!-- end -->
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
                                        <th>@lang('app.warehouse')</th>
                                        <!-- <th>Longitude</th>
                                        <th>Latitude</th>
                                        <th>@lang('app.area')</th> -->
                                        <th>@lang('app.control')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($stands->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($stands->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($stands as $branch)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $branch->title }}</td>

                                            <td>{{ $branch->warehouse->trans('title') }}</td>
                                            <!--
                                            <th>{{ $branch->longitude }}</th>
                                            <th>{{ $branch->latitude }}</th>

                                              <td>{{ $branch->area }}</td> -->
                                            <td>
                                                <!-- <a aria-disabled="true"  href="{{ route('warehouse_package.edit', $branch->id) }}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                            class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a> -->


                                                <form style="display: inline;"
                                                    action="{{ route('warehouse_package.destroy', $branch->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you want Delete This Record ?');">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.warehouse')</th>
                                        <!-- <th>Longitude</th>
                     <th>Latitude</th>
                      <th>@lang('app.area')</th> -->
                                        <th>@lang('app.control')</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <nav>
                                <ul class="pager">
                                    {{ $stands->appends($_GET)->links() }}
                                </ul>

                            </nav>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
