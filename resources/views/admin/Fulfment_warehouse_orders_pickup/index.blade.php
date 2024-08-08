@extends('layouts.master')
@section('pageTitle', 'orders')

@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
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


                        <div class="tab-content">
                            <div class="active tab-pane" id="filter1">
                                <div class="row ">
                                    <div class="row" style="padding:12px">
                                        <!-- filtter -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal">
                                            {{ __('admin_message.Search and filter') }} </button>

                                        <!-- endif -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-body">
                                                        <form action="{{ route('client_orders_pickup.index') }}"
                                                            method="GET">

                                                            <input type="hidden" value="{{ $work_type }}"
                                                                name="work_type">
                                                                <input type="hidden" value="search" name="type">

                                                            <div class="col-lg-6">
                                                                <label>  {{ __('fulfillment.fulfillment_client_name') }} </label>
                                                                <select class="form-control select2" name="user_id">
                                                                    <option value="">
                                                                      {{ __('fulfillment.fulfillment_client_name') }} 
                                                                    </option>
                                                                    @foreach ($clients as $client)
                                                                        <option
                                                                            {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                                            value="{{ $client->id }}">{{ $client->name }} |
                                                                            {{ $client->store_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">

                                                            <label> {{__('admin_message.Warehouse Branches')}} </label>
                                                                <select  id="warhouse_id" value="" class="form-control select2"
                                                                    name="warehouse_id">
                                                                    <option value="">{{__('admin_message.Select')}}
                                                                        {{__('admin_message.Warehouse Branches')}}</option>
                                                                    @foreach ($warehouse_branches as $warhouse)
                                                                    <option value="{{$warhouse->id}}">{{$warhouse->trans('title')}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>@lang('order.from_date')</label>
                                                                <input type="date" name="from"
                                                                    value="{{ isset($from) ? $from : '' }}"
                                                                    class="form-control" >
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group ">
                                                                    <label for="to">@lang('order.to_date')</label>
                                                                    <input type="date" name="to"
                                                                        value="{{ isset($to) ? $to : '' }}"
                                                                        class="form-control" >
                                                                </div>
                                                            </div>
                                                         
                                                            <div class="col-lg-6">
                                                                <label>{{ __('admin_message.statuses') }}</label>
                                                                <select class="form-control select2" name="status_id">
                                                                    <option value="">
                                                                        {{ __('admin_message.Choose a statuses') }}</option>
                                                                 
                                                                        @foreach ($statuses as $status)
                                                                        <option
                                                                            {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                                            value="{{ $status->id }}">{{ $status->trans('title') }}
                                                                        </option>
                                                                        @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                                            <div  class="col-lg-6">
                                                                <label class="control-label">{{__('admin_message.Delivery Service')}}</label>
                                                                <div>
                                                                    <select id="delivery_service" class="form-control select2" name="delivery_service">
                                                                        <option value="">{{__('admin_message.Select')}}</option>
                                                                        <option value="0">{{__('admin_message.No')}}</option>
                                                                        <option value="1">{{__('admin_message.Yes')}}</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                        <div class="modal-footer">

                                                            <div class="col-lg-6">
                                                                <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                                                    value="{{ __('admin_message.search') }}" />
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
                                    </div>
                                </div>
                                @if ($work_type == 4)
                                    <div class="col-md-6">
                                        <form action="{{ route('pickup_order.change_status_all') }}" method="POST">
                                            <td><input type="hidden" name="order_id[]" value="" id="ordersId"></td>
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group col-md-8 ">
                                                <select class="form-control select2" id="status_id" name="status_id">
                                                    <option value=""> {{ __('admin_message.Choose a statuses') }}
                                                    </option>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status->id }}">{{ $status->trans('title') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 ">
                                                <input type="submit" class="btn btn-success"
                                                    value="{{ __('admin_message.Status change') }}">

                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <form action="{{ route('pickup_order.assign_delegate') }}" method="POST">

                                            <td><input type="hidden" name="orders[]" value="" id="passordersId">
                                                <input type="hidden" name="type" value="data">
                                            </td>
                                            @csrf
                                            @method('PUT')

                                            <div class="col-md-8">
                                                <select class="form-control select2" name="delegate_id" >
                                                    <option value="">{{ __('admin_message.Choose a Delegate') }}
                                                    </option>
                                                    @foreach ($delegates as $delegate)
                                                        <option value="{{ $delegate->id }}">{{ $delegate->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="submit" class="btn btn-success btn-block"
                                                    value="{{ __('admin_message.Assign To Delegate') }}">
                                            </div>

                                        </form>

                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="nav-tabs-custom" style="padding:12px">
                            <div class="row">
                                @if (
                                    ($work_type == 3 && in_array('add_pickup_order_warehouse', $permissionsTitle)) ||
                                        ($work_type == 4 && in_array('add_pickup_order_fulfillment', $permissionsTitle)))
                                    <div class="col-lg-3 col-xs-12">
                                        <a class="btn btn-success pull-right"
                                            href="{{ route('client_orders_pickup.create', ['work_type' => $work_type]) }}">@lang('order.add_new_order')
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="box">

                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>@lang('order.order_id')</th>
                                            <th>
                                                @if ($work_type == 3)
                                                    {{ __('admin_message.Warehouse Name') }}
                                                @else
                                                    {{ __('fulfillment.fulfillment_client_name') }}
                                                @endif
                                            </th>
                                            <th>{{ __('admin_message.Warehouse Branches') }}</th>
                                            <th>{{ __('admin_message.Storage types') }}</th>
                                            <th> {{ __('admin_message.Sizes') }}</th>
                                            <th> {{ __('admin_message.Delivery Service') }}</th>
                                            <th> {{ __('order.date') }}</th>
                                            <th> {{ __('order.status') }}</th>
                                            @if ($work_type == 4)
                                                <th>{{ __('admin_message.Delegate') }}</th>
                                            @endif
                                            <th>@lang('order.more')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($orders->currentPage() == 1) {
                                            $count = 1;
                                        } else {
                                            $count = ($orders->currentPage() - 1) * 50 + 1;
                                        }
                                        ?>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><input type="checkbox" name="orders[]" value="{{ $order->id }}"
                                                        class="ordersId"></td>
                                                <td>{{ $count }}</td>
                                                <td>{{ $order->order_id }}</td>
                                                <td> {{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                                                <td>
                                                    {{ !empty($order->warehouse) ? $order->warehouse->trans('title') : '' }}
                                                </td>
                                                <td>
                                                    {{ $order->storage_types == 1 ? __('admin_message.pallet') : __('admin_message.Carton') }}
                                                </td>
                                                <td>
                                                    {{ !empty($order->size) ? $order->size->trans('name') : '' }}
                                                </td>
                                                <td> {{ $order->delivery_service == 1 ? __('admin_message.Yes') : __('admin_message.No') }}
                                                </td>
                                                <td>{{ $order->updated_at }}</td>
                                                <td>{{ $order->status? $order->status->trans('title') : '' }}</td>
                                                @if ($work_type == 4)
                                                    <td>{{ !empty($order->delegate) ? $order->delegate->name : '' }}</td>
                                                @endif
                                                <td>
                                                    <!--  -->
                                                    @if(count($order->Client_packages_good)==0)
                                                    <a href="{{ route('packages_good.scan', $order->id) }}"
                                                        title="View" class="btn btn-sm btn-info"
                                                        style="margin: 2px;"><i class="fa fa-eye"></i>
                                                        <span
                                                            class="hidden-xs hidden-sm">{{ __('admin_message.Packaging goods/cartons') }}</span>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('packages_good.scan_details', $order->id) }}"
                                                        title="View" class="btn btn-sm btn-info"
                                                        style="margin: 2px;"><i class="fa fa-eye"></i>
                                                        <span
                                                            class="hidden-xs hidden-sm">{{ __('admin_message.details') }} {{ __('admin_message.Packaging goods/cartons') }}</span>
                                                    </a>

                                                    @endif
                                                    <!--  -->
                                                    @if (
                                                        ($work_type == 3 && in_array('show_pickup_order_warehouse', $permissionsTitle)) ||
                                                            ($work_type == 4 && in_array('show_pickup_order_fulfillment', $permissionsTitle)))
                                                        <a href="{{ route('client_orders_pickup.show', $order->id) }}"
                                                            title="View" class="btn btn-sm btn-warning"
                                                            style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                                class="hidden-xs hidden-sm">@lang('app.view')</span> </a>
                                                    @endif
                                                    @if (
                                                        ($work_type == 3 && in_array('delete_pickup_order_warehouse', $permissionsTitle)) ||
                                                            ($work_type == 4 && in_array('delete_pickup_order_fulfillment', $permissionsTitle)))
                                                        <form class="pull-right" style="display: inline;"
                                                            action="{{ route('client_orders_pickup.destroy', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Do you want Delete This Record ?');">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                                {{ __('admin_message.Delete') }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (
                                                        ($work_type == 3 && in_array('edit_pickup_order_warehouse', $permissionsTitle)) ||
                                                            ($work_type == 4 && in_array('edit_pickup_order_fulfillment', $permissionsTitle)))
                                                        <a href="{{ route('client_orders_pickup.edit', $order->id) }}"
                                                            title="View" class="btn btn-sm btn-info"
                                                            style="margin: 2px;"><i class="fa fa-edit"></i>
                                                            <span
                                                                class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span>
                                                        </a>
                                                    @endif


                                                </td>


                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>@lang('order.order_id')</th>
                                            <th>
                                                @if ($work_type == 3)
                                                    {{ __('admin_message.Warehouse Name') }}
                                                @else
                                                    {{ __('fulfillment.fulfillment_client_name') }}
                                                @endif
                                            </th>
                                            <th>{{ __('admin_message.Warehouse Branches') }}</th>
                                            <th>{{ __('admin_message.Storage types') }}</th>
                                            <th> {{ __('admin_message.Sizes') }}</th>
                                            <th> {{ __('admin_message.Delivery Service') }}</th>
                                            <th> {{ __('order.date') }}</th>
                                            <th> {{ __('order.status') }}</th>
                                            @if ($work_type == 4)
                                                <th>{{ __('admin_message.Delegate') }}</th>
                                            @endif
                                            <th>@lang('order.more')</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {!! $orders->appends($_GET)->links() !!}

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Orders</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/client/place_order_excel') }}" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group @if ($errors->has('excel')) has-error @endif">
                            <label for="excel-field">File Excel</label>
                            <input type="file" id="excel-field" name="import_file" class="form-control"
                                accept=".xlsx, .xls, .csv" required />
                            @if ($errors->has('excel'))
                                <span class="help-block">{{ $errors->first('excel') }}</span>
                            @endif
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('order.Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('order.Save Upload')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script
        src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
        type="text/javascript"></script>

    <script>
        setTimeout(function() {
            document.getElementById('error-alert').style.display = 'none';
        }, 5000);

        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
        }, 3000);
    </script>
    <script>
        $(document).ready(function() {
            $("#checkAll").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);

                var arr = [];
                $('input:checkbox:checked').each(function() {
                    arr.push($(this).val());
                });

                $('#ordersId').val(arr)
                $('#passordersId').val(arr)

            });
            $(".ordersId").on('change', function() {
                var arr = [];
                $('input:checkbox:checked').each(function() {
                    arr.push($(this).val());
                });

                $('#ordersId').val(arr)
                $('#passordersId').val(arr)


            });
        });

        $(document).ready(function() {
            $('#example1').DataTable({
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },

                retrieve: true,
                fixedColumns: true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                pageLength: 50,

                direction: "ltr",
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }


                    },

                    {
                        extend: 'excelHtml5',
                        footer: false,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    }
                ],
            });
        });
    </script>
      <style>
        .select2-container {
            display: block !important;
        }

        .col-lg-6 {
            margin-bottom: 10px;
        }
    </style>

@endsection
