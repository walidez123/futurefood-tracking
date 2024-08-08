@extends('layouts.master')
@section('pageTitle', __('admin_message.Bulk invoices'))
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

                        <div class="tab-content">
                            <div class="active tab-pane" id="filter1">
                                <div class="row text-center">
                                    <form method="GET">
                                        <div class="col-lg-3">
                                            <label>@lang('balance.Clients')</label>
                                            <select class="form-control select2" name="user_id">
                                                <option value="">@lang('balance.Select Client') </option>
                                                @foreach ($clients as $client)
                                                    <option
                                                        {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                        value="{{ $client->id }}">{{ $client->name }} |
                                                        {{ $client->store_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>@lang('balance.From')</label>
                                            <input required type="date" name="from"
                                                value="{{ isset($from) ? $from : '' }}" class="form-control">
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                <label for="to">@lang('balance.To') </label>
                                                <input required type="date" name="to"
                                                    value="{{ isset($to) ? $to : '' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group ">

                                                <button type="submit" class="btn btn-block btn-primary"
                                                    formaction="{{ route('report.index') }}">{{ __('admin_message.search') }}</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                @if (in_array('add_invoice', $permissionsTitle))
                                                    <button type="submit" class="btn btn-block btn-primary"
                                                        formaction="{{ route('report.create') }}">{{ __('admin_message.Create a report') }}</button>
                                                @endif
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

                                <table id="example1"
                                    class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin_message.invoice number') }}</th>
                                            <th>{{ __('admin_message.Client') }}</th>
                                            <th>{{ __('admin_message.invoice from') }}</th>
                                            <th>{{ __('admin_message.Invoice to') }}</th>
                                            <th>{{ __('admin_message.Total invoice') }}</th>
                                            <th>{{ __('admin_message.Processes') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Invoices as $i => $Invoice)
                                            <tr>
                                                <td><input type="checkbox" name="orders[]" value="{{ $Invoice->id }}"
                                                        class=""></td>
                                                <td>{{ $Invoice->InvoceNum }}</td>

                                                <td>{{ $Invoice->user->store_name }}</td>
                                                <td>{{ $Invoice->start_date }}</td>
                                                <td>{{ $Invoice->end_date }}</td>
                                                <td>{{ $Invoice->Glopaltotal }}</td>
                                                <td>
                                                    @if (in_array('add_invoice', $permissionsTitle))
                                                        <a href="{{ route('report.invoice', $Invoice->id) }}"
                                                            title="invoice" class="pull-left btn btn-sm btn-success"
                                                            style="margin: 2px;"><i class="fa fa-history fa-spin"></i> <span
                                                                class="hidden-xs hidden-sm">invoice</span> </a>
                                                    @endif
                                                    @if (in_array('show_invoice', $permissionsTitle))
                                                        <a href="{{ route('report.show', $Invoice->id) }}" title="invoice"
                                                            class="pull-left btn btn-sm btn-success" style="margin: 2px;"><i
                                                                class="fa fa-eye"></i> <span
                                                                class="hidden-xs hidden-sm">show</span> </a>
                                                    @endif

                                                    @if (in_array('delete_invoice', $permissionsTitle))
                                                        <form class="pull-left" style="display: inline;"
                                                            action="{{ route('report.destroy', $Invoice->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Do you want Delete This Record ?');">
                                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>{{ __('admin_message.invoice number') }}</th>
                                            <th>{{ __('admin_message.Client') }}</th>
                                            <th>{{ __('admin_message.invoice from') }}</th>
                                            <th>{{ __('admin_message.Invoice to') }}</th>
                                            <th>{{ __('admin_message.Total invoice') }}</th>
                                            <th>{{ __('admin_message.Processes') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><!-- /.box-body -->

                            {!! $Invoices->appends($_GET)->links() !!}

                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {

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
            });
            $(".ordersId").on('change', function() {
                var arr = [];
                $('input:checkbox:checked').each(function() {
                    arr.push($(this).val());
                });

                $('#ordersId').val(arr)

                $('#passordersId').val(arr)


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

                buttons: [{
                        extend: 'print',
                        footer: false,
                        header: false,
                        title: "RUN SHEET",
                        text: "RUN SHEET",
                        exportOptions: {
                            stripHtml: false,
                            columns: [0, 1, 2, 3, 4, 5, 6]
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
    </script>
@endsection
