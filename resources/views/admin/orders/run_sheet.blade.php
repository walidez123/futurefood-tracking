@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))

@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <style>
            .paging_simple_numbers {
                display: none !important;
            }
        </style>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        @if (session('success'))
                            <div id="success-alert" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div id="error-alert" class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif


                        @if ($errors->any())
                            <div id="error-alert" class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="tab-content">
                            <div class="active tab-pane" id="filter1">
                                <div class="row ">
                                    <form action="{{ route('run_sheet.index') }}" method="GET" class="col-xs-12">
                                        <input type="hidden" name="work_type" value="{{ $work_type }}">
                                        <input type="hidden" name="type" value="ship">

                                        <div class="col-lg-3">
                                            @if ($work_type == 2)
                                                <label>{{ __('admin_message.restaurants') }}</label>
                                            @elseif ($work_type == 1)
                                                <label>{{ __('admin_message.Clients') }}</label>
                                            @elseif ($work_type == 3)
                                                <label> {{ __('admin_message.Warehouse Clients') }}</label>
                                            @elseif ($work_type == 4)
                                                <label> {{ __('fulfillment.fulfillment_clients') }}</label>
                                            @endif
                                            <select class="form-control select2" name="user_id">
                                                @if ($work_type == 1)
                                                    <option value="">
                                                        {{ __('admin_message.Choose a store') }}</option>
                                                    </option>
                                                @elseif($work_type == 2)
                                                    <option value="">
                                                        {{ __('admin_message.Choose a restaurant') }}
                                                    </option>
                                                @elseif ($work_type == 3)
                                                    <option value=""> {{ __('admin_message.Select') }}
                                                        {{ __('admin_message.Warehouse Clients') }}</option>
                                                @elseif ($work_type == 4)
                                                    <option value="">{{ __('admin_message.Select') }}
                                                        {{ __('fulfillment.fulfillment_clients') }}</option>
                                                @endif
                                                @foreach ($clients as $client)
                                                    <option
                                                        {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                        value="{{ $client->id }}">{{ $client->name }} |
                                                        {{ $client->store_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>{{ __('admin_message.statuses') }}</label>
                                            <select class="form-control select2" name="status_id">
                                                <option value="">
                                                    {{ __('admin_message.Choose a statuses') }}</option>
                                                @if ($work_type == 1)
                                                    @foreach ($store_statuses as $status)
                                                        <option
                                                            {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">{{ $status->trans('title') }}
                                                        </option>
                                                    @endforeach
                                                @elseif($work_type == 2)
                                                    @foreach ($rest_statuses as $status)
                                                        <option
                                                            {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">{{ $status->trans('title') }}
                                                        </option>
                                                    @endforeach

                                                @elseif($work_type == 4)
                                                    @foreach ($full_statuses as $status)
                                                        <option
                                                            {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">{{ $status->trans('title') }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>{{ __('admin_message.The delegates') }}</label>
                                            <select required class="form-control select2" name="delegate_id">
                                                <option value="">
                                                    {{ __('admin_message.Select a delegate') }}</option>
                                                @foreach ($delegates as $client)
                                                    <option
                                                        {{ isset($delegate_id) && $delegate_id == $client->id ? 'selected' : '' }}
                                                        value="{{ $client->id }}">{{ $client->name }} |
                                                        {{ $client->store_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>{{ __('admin_message.Payment status') }}</label>
                                            <select class="form-control select2" name="contact_status">
                                                <option value="">{{ __('admin_message.Paid') }}
                                                </option>
                                                <option
                                                    {{ isset($contact_status) && $contact_status == 1 ? 'selected' : '' }}
                                                    value="1">Yes</option>
                                                <option
                                                    {{ isset($contact_status) && $contact_status == 0 ? 'selected' : '' }}
                                                    value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>{{ __('admin_message.from') }}</label>
                                            <input type="date" name="from" value="{{ isset($from) ? $from : '' }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group ">
                                                <label for="to">{{ __('admin_message.to') }}</label>
                                                <input type="date" name="to" value="{{ isset($to) ? $to : '' }}"
                                                    class="form-control">
                                            </div>
                                        </div>


                                </div>
                                <div class="modal-footer">

                                    <div class="col-lg-3">
                                        <button type="submit" name="action" class="btn btn-block btn-danger col-lg-6"
                                            value="search">{{ __('admin_message.search') }}</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" name="action" class="btn btn-block btn-success col-lg-6"
                                            value="pdf"> <i class="fa-solid fa-download"></i>
                                            {{ __('admin_message.run sheet') }}</button>
                                    </div>

                                </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <table id="{{ $work_type == 1 ? '' : '' }}"
                                class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin_message.Order Number') }}</th>
                                        <!-- <th width="20%">#</th>
                        <th width="30%">#</th>
                        <th width="25%"></th>
                        <th width="25%"></th> -->
                                        <th>
                                            @if ($work_type == 2)
                                                <label>{{ __('admin_message.restaurants') }}</label>
                                            @elseif ($work_type == 1)
                                                <label>{{ __('admin_message.Clients') }}</label>
                                            @elseif ($work_type == 3)
                                                <label> {{ __('admin_message.Warehouse Clients') }}</label>
                                            @elseif ($work_type == 4)
                                                <label> {{ __('fulfillment.fulfillment_clients') }}</label>
                                            @endif

                                        </th>

                                        <th>{{ __('admin_message.Shipping from') }}</th>
                                        <th>{{ __('admin_message.Client name') }}</th>
                                        <th>{{ __('admin_message.Phone') }}</th>
                                        <th>{{ __('admin_message.Amount') }}</th>
                                        <th>{{ __('admin_message.Shipping to') }}</th>
                                        <th>{{ __('admin_message.Date') }}</th>
                                        <th>{{ __('admin_message.number') }}</th>
                                        <th>{{ __('admin_message.reference_number') }}</th>
                                        <th>{{ __('admin_message.Current') }}</th>
                                        <th>{{ __('admin_message.Delegate') }}</th>
                                        <th>{{ __('admin_message.Service provider') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @if (isset($orders) && count($orders) > 0)
                                        @foreach ($orders as $order)
                                            <tr>

                                                <td>{{ $count }}</td>
                                                <td>{{ $order->order_id }}</td>



                                                <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                                                <td>{{ !empty($order->senderCity) ? $order->senderCity->trans('title') : '' }}
                                                </td>
                                                <td>{{ $order->receved_name }}</td>
                                                <td>{{ $order->receved_phone }}</td>
                                                <td>{{ $order->amount }}</td>
                                                <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
                                                </td>
                                                <td style="    width:6%;">{{ $order->pickup_date }}</td>
                                                <td>{{ $order->number_count }}</td>
                                                <td>{{ $order->reference_number }}</td>

                                                <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }} <br>
                                                    {{ $order->updated_at }}</td>

                                                <td>{{ !empty($order->delegate) ? $order->delegate->name : '' }}</td>
                                                <td>{{ !empty($order->service_provider) ? $order->service_provider->name : '' }}
                                                </td>


                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>

                                        <th>#</th>
                                        <th>{{ __('admin_message.Order Number') }}</th>
                                        <!-- <th></th>
                        <th>#</th>
                        <th></th>
                        <th></th> -->
                                        <th>
                                            @if ($work_type == 2)
                                                <label>{{ __('admin_message.restaurants') }}</label>
                                            @elseif ($work_type == 1)
                                                <label>{{ __('admin_message.Clients') }}</label>
                                            @elseif ($work_type == 3)
                                                <label> {{ __('admin_message.Warehouse Clients') }}</label>
                                            @elseif ($work_type == 4)
                                                <label> {{ __('fulfillment.fulfillment_clients') }}</label>
                                            @endif

                                        </th>

                                        <th>{{ __('admin_message.Shipping from') }}</th>
                                        <th>{{ __('admin_message.Client name') }}</th>
                                        <th>{{ __('admin_message.Phone') }}</th>
                                        <th>{{ __('admin_message.Amount') }}</th>
                                        <th>{{ __('admin_message.Shipping to') }}</th>
                                        <th>{{ __('admin_message.Date') }}</th>
                                        <th>{{ __('admin_message.number') }}</th>
                                        <th>{{ __('admin_message.reference_number') }}</th>
                                        <th>{{ __('admin_message.Current') }}</th>
                                        <th>{{ __('admin_message.Delegate') }}</th>
                                        <th>{{ __('admin_message.Service provider') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->


                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <div class="modal fade" id="exampleModalExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> @lang('order.import_order')</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/admin/place_order_excel') }}" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-lg-12">
                            @if ($work_type == 2)
                                <label>{{ __('admin_message.restaurants') }}</label>
                            @else
                                <label>{{ __('admin_message.Clients') }}</label>
                            @endif
                            <select class="form-control select2" name="user_id" required>
                                @if ($work_type == 1)
                                    <option value="">
                                        {{ __('admin_message.Choose a store') }}</option>
                                    </option>
                                @else
                                    <option value="">
                                        {{ __('admin_message.Choose a restaurant') }}
                                    </option>
                                @endif
                                @foreach ($clients as $client)
                                    <option {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                        value="{{ $client->id }}">{{ $client->name }} |
                                        {{ $client->store_name }}</option>
                                @endforeach

                            </select>
                        </div>

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

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
 
</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script
    src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
    type="text/javascript"></script>
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
                $('#serviceordersId').val(arr)
                $('#ordersPolicy').val(arr)



            });
            $(".ordersId").on('change', function() {
                var arr = [];
                $('input:checkbox:checked').each(function() {
                    arr.push($(this).val());
                });

                $('#ordersId').val(arr)

                $('#passordersId').val(arr)
                $('#serviceordersId').val(arr)
                $('#ordersPolicy').val(arr)

            });
            $(function() {
                $('.select2').select2()
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
                direction: "ltr",
                pageLength: 50,
                scrollX: true,
                dom: 'lBfrtip',
                "columnDefs": [{
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },

                    {
                        "targets": [3],
                        "visible": false
                    },
                    {
                        "targets": [4],
                        "visible": false
                    }, {
                        "targets": [5],
                        "visible": false
                    }, {
                        "targets": [6],
                        "visible": false
                    }
                ],
                buttons: [{
                        extend: 'print',
                        footer: false,
                        header: false,
                        title: "RUN SHEET",
                        text: "RUN SHEET",
                        exportOptions: {
                            stripHtml: false,
                            columns: [0, 1, 3, 4, 5, 6]
                        },
                        "columnDefs": [{
                            "width": "20%",
                            "targets": 6
                        }]


                    },


                    {
                        extend: 'excelHtml5',
                        footer: false,

                        exportOptions: {
                            columns: [0, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        }
                    }
                ],

            });

        });


        $(document).ready(function() {
            $('#example2').DataTable({
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
                scrollX: true,
                dom: 'lBfrtip',
                "columnDefs": [{
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },

                    {
                        "targets": [3],
                        "visible": false
                    },
                    {
                        "targets": [4],
                        "visible": false
                    }, {
                        "targets": [5],
                        "visible": false
                    }, {
                        "targets": [6],
                        "visible": false
                    }
                ],
                buttons: [{
                    extend: 'excelHtml5',
                    footer: false,

                    exportOptions: {
                        columns: [0, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                    }
                }],

            });

        });
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('error-alert').style.display = 'none';
        }, 5000);

        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
        }, 3000);
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
