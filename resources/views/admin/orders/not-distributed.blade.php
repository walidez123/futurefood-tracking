@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))
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

        @include('layouts._header-index', [
            'title' => __('admin_message.orders'),
            'iconClass' => 'fa-truck',
            'addUrl' => '',
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs ">

                            <li class="active"><a data-toggle="tab" href="#menu1">{{ __('admin_message.new') }}</a></li>
                            <li><a data-toggle="tab" href="#menu2">{{ __('admin_message.old') }}</a></li>


                        </ul>


                        <div class="row">
                            <div class="col-xs-12">
                                @if ($work_type == 1)
                                    <form action="{{ route('client-orders.index') }}/?notDelegated1" method="GET">
                                    @else
                                        <form action="{{ route('client-orders.index') }}/?notDelegated2" method="GET">
                                @endif

                                <div class="col-lg-3">
                                    <label>@lang('admin_message.from city')</label>
                                    <select class="form-control select2 col-md-12" name="sender_city">
                                        <option value="">@lang('admin_message.Select a city')</option>
                                        @if (!empty($cities))
                                            @foreach ($cities as $city)
                                                <option
                                                    {{ !empty($sender_city) && $sender_city == $city->id ? 'selected' : '' }}
                                                    value="{{ $city->id }}">{{ $city->trans('title') }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>@lang('admin_message.To a city')</label>
                                    <select class="form-control select2" name="receved_city">
                                        <option value="">@lang('admin_message.Select a city')</option>
                                        @if (!empty($cities))
                                            @foreach ($cities as $city)
                                                <option
                                                    {{ !empty($receved_city) && $receved_city == $city->id ? 'selected' : '' }}
                                                    value="{{ $city->id }}">{{ $city->trans('title') }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        @if ($work_type == 1)
                                            <input type="hidden" name="type" value="notDelegated1">
                                        @else
                                            <input type="hidden" name="type" value="notDelegated2">
                                        @endif
                                        <option value="">@lang('admin_message.filter')</option>
                                        <input type="submit" value="{{trans('admin_message.filter')}}" class="btn btn-block btn-primary" />
                                    </div>
                                </div>
                                </form>

                            </div>
                        </div>
                        <div class="tab-content col-md-12">
                            <div id="menu1" class="tab-pane fade in active">
                                <form action="{{ route('order.distribute') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title"> </h3>
                                            <div class="col-sm-12 invoice-col">
                                                <div class="col-md-4">
                                                    <label>@lang('admin_message.Delegates')</label>
                                                    <select class="form-control select2" name="delegate_id" required>
                                                        <option value="">@lang('order.select_delegate') </option>

                                                        @foreach ($delegates as $delegate)
                                                            <option value="{{ $delegate->id }}">{{ $delegate->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-xs-12">
                                                @if (in_array('distribution_order', $permissionsTitle))

                                                    <label>@lang('admin_message.enter_pass')</label>

                                                    <input type="submit" class="btn btn-success btn-block" value="{{trans('admin_message.enter_pass')}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <table id="example1_filter"
                                                class="data_table  datatable table table-bordered table-striped example1_filter">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll"></th>
                                                        <th>#</th>
                                                        <th>{{ trans('order.order_id') }}</th>
                                                        <th>{{ trans('order.store_name') }}</th>
                                                        <th>{{ trans('order.ship_from') }}</th>
                                                        <th>{{ trans('order.received_name') }}</th>
                                                        <th>{{ trans('order.ship_to') }}</th>
                                                        <th>{{ trans('order.ship_address') }}</th>
                                                        <th>{{ trans('order.ship_date') }}</th>
                                                        <th>{{ trans('order.status') }}</th>
                                                        <th>{{ trans('order.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 1; ?>

                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td><input type="checkbox" name="orders[]"
                                                                    value="{{ $order->id }}"></td>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $order->order_id }}</td>
                                                            <td>{{ !empty($order->user) ? $order->user->store_name : '' }}
                                                            </td>
                                                            <td>{{ !empty($order->senderCity) ? $order->senderCity->trans('title') : '' }}
                                                            </td>
                                                            <td>{{ $order->receved_name }}</td>
                                                            <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
                                                            </td>
                                                            <td>{{ $order->receved_address }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                            <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }}
                                                            </td>
                                                            <td>
                                                                @if ($order->work_type == 1)
                                                                    @if (in_array('show_order', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.show', $order->id) }}"
                                                                            title="View" class="btn btn-sm btn-warning"
                                                                            style="margin: 2px;"><i class="fa fa-eye"></i>
                                                                            <span class="hidden-xs hidden-sm">View</span>
                                                                        </a>
                                                                        @endif
                                                                        @if (in_array('show_history_order', $permissionsTitle))

                                                                        <a href="{{ route('client-orders.history', $order->id) }}"
                                                                            title="History" class="btn btn-sm btn-success"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-history fa-spin"></i> <span
                                                                                class="hidden-xs hidden-sm">History</span>
                                                                        </a>
                                                                    @endif
                                                                    @if (in_array('edit_order', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.edit', $order->id) }}"
                                                                            title="pass order to delegate "
                                                                            class="btn btn-sm btn-primary"
                                                                            style="margin: 2px;"><i class="fa fa-truck"></i>
                                                                            <span class="hidden-xs hidden-sm">Edit
                                                                            </span></a>
                                                                    @endif
                                                                @else
                                                                    @if (in_array('show_order_res', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.show', $order->id) }}"
                                                                            title="View" class="btn btn-sm btn-warning"
                                                                            style="margin: 2px;"><i class="fa fa-eye"></i>
                                                                            <span class="hidden-xs hidden-sm">View</span>
                                                                        </a>
                                                                        @endif
                                                                        @if (in_array('show_history_order', $permissionsTitle))

                                                                        <a href="{{ route('client-orders.history', $order->id) }}"
                                                                            title="History" class="btn btn-sm btn-success"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-history fa-spin"></i> <span
                                                                                class="hidden-xs hidden-sm">History</span>
                                                                        </a>
                                                                    @endif

                                                                    @if (in_array('edit_order_res', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.edit', $order->id) }}"
                                                                            title="pass order to delegate "
                                                                            class="btn btn-sm btn-primary"
                                                                            style="margin: 2px;"><i class="fa fa-truck"></i>
                                                                            <span class="hidden-xs hidden-sm">Edit
                                                                            </span></a>
                                                                    @endif
                                                                @endif




                                                            </td>
                                                        </tr>
                                                        <?php $count++; ?>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </form>
                            </div>
                            <div id="menu2" class="tab-pane ">
                                <form action="{{ route('order.distribute') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title"> </h3>
                                            <div class="col-sm-12 invoice-col">
                                                <div class="col-md-4">
                                                    <label>@lang('admin_message.Delegates')</label>
                                                    <select class="form-control select2" name="delegate_id" required>
                                                        <option value="">@lang('order.select_delegate') </option>

                                                        @foreach ($delegates as $delegate)
                                                            <option value="{{ $delegate->id }}">{{ $delegate->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-xs-12">
                                                @if (in_array('distribution_order', $permissionsTitle))

                                                    <label>enter pass</label>
                                                    <input type="submit" class="btn btn-success btn-block"
                                                        value="Pass">
                                                @endif
                                                </div>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <table id="example2_filter"
                                                class="data_table  datatable table table-bordered table-striped example1_filter">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll"></th>
                                                        <th>#</th>
                                                        <th>{{ trans('order.order_id') }}</th>
                                                        <th>{{ trans('order.store_name') }}</th>
                                                        <th>{{ trans('order.ship_from') }}</th>
                                                        <th>{{ trans('order.received_name') }}</th>
                                                        <th>{{ trans('order.ship_to') }}</th>
                                                        <th>{{ trans('order.ship_address') }}</th>
                                                        <th>{{ trans('order.ship_date') }}</th>
                                                        <th>{{ trans('order.status') }}</th>
                                                        <th>{{ trans('order.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 1; ?>

                                                    @foreach ($delegatedorders as $order)
                                                        <tr>
                                                            <td><input type="checkbox" name="orders[]"
                                                                    value="{{ $order->id }}"></td>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $order->order_id }}</td>
                                                            <td>{{ !empty($order->user) ? $order->user->store_name : '' }}
                                                            </td>
                                                            <td>{{ !empty($order->senderCity) ? $order->senderCity->trans('title') : '' }}
                                                            </td>
                                                            <td>{{ $order->receved_name }}</td>
                                                            <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
                                                            </td>
                                                            <td>{{ $order->receved_address }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                            <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }}
                                                            </td>
                                                            <td>
                                                                @if ($order->work_type == 1)
                                                                    @if (in_array('show_order', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.show', $order->id) }}"
                                                                            title="View" class="btn btn-sm btn-warning"
                                                                            style="margin: 2px;"><i class="fa fa-eye"></i>
                                                                            <span class="hidden-xs hidden-sm">View</span>
                                                                        </a>
                                                                        @endif
                                                                        @if (in_array('show_history_order', $permissionsTitle))

                                                                        <a href="{{ route('client-orders.history', $order->id) }}"
                                                                            title="History" class="btn btn-sm btn-success"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-history fa-spin"></i> <span
                                                                                class="hidden-xs hidden-sm">History</span>
                                                                        </a>
                                                                    @endif
                                                                    @if (in_array('edit_order', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.edit', $order->id) }}"
                                                                            title="pass order to delegate "
                                                                            class="btn btn-sm btn-primary"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-truck"></i> <span
                                                                                class="hidden-xs hidden-sm">Edit
                                                                            </span></a>
                                                                    @endif
                                                                @else
                                                                    @if (in_array('show_order_res', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.show', $order->id) }}"
                                                                            title="View" class="btn btn-sm btn-warning"
                                                                            style="margin: 2px;"><i class="fa fa-eye"></i>
                                                                            <span class="hidden-xs hidden-sm">View</span>
                                                                        </a>
                                                                        @endif
                                                                        @if (in_array('show_history_order', $permissionsTitle))

                                                                        <a href="{{ route('client-orders.history', $order->id) }}"
                                                                            title="History" class="btn btn-sm btn-success"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-history fa-spin"></i> <span
                                                                                class="hidden-xs hidden-sm">History</span>
                                                                        </a>
                                                                    @endif


                                                                    @if (in_array('edit_order_res', $permissionsTitle))
                                                                        <a href="{{ route('client-orders.edit', $order->id) }}"
                                                                            title="pass order to delegate "
                                                                            class="btn btn-sm btn-primary"
                                                                            style="margin: 2px;"><i
                                                                                class="fa fa-truck"></i> <span
                                                                                class="hidden-xs hidden-sm">Edit
                                                                            </span></a>
                                                                    @endif
                                                                @endif




                                                            </td>
                                                        </tr>
                                                        <?php $count++; ?>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </form>

                            </div>
                        </div>


                    </div><!-- /.col -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#checkAll").click(function() {

                $('input:checkbox').not(this).prop('checked', this.checked);

            });
            $(function() {
                $('.select2').select2()
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1_filter').DataTable({
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },

                retrieve: true,
                fixedColumns: true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength: 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example2_filter').DataTable({
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },
                retrieve: true,
                fixedColumns: true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength: 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            });
        });
    </script>
@endsection
