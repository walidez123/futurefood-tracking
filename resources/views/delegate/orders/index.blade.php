@extends('layouts.master')
@section('pageTitle', 'orders')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('layouts._header-index', [
            'title' => 'order',
            'iconClass' => 'fa-truck',
            'addUrl' => '',
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">


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
                                        {{-- <th>#</th>
                                        <th width="20%">#</th>
                                        <th width="30%">#</th>
                                        <th width="25%"></th>
                                        <th width="25%"></th> --}}
                                        <th>@lang('app.Order_id')</th>
                                        <th>@lang('app.Store_Name') </th>
                                        <th>@lang('app.ship') @lang('app.from') </th>
                                        <th>@lang('app.Receved_Name')</th>
                                        <th>@lang('app.phone')</th>
                                        <th>@lang('app.amount')</th>
                                        <th>@lang('app.ship') @lang('app.to')</th>
                                        <th>@lang('app.ship_date')</th>
                                        <th>@lang('app.count')</th>
                                        <th>@lang('app.change') @lang('app.status')</th>
                                        <th>@lang('app.status')</th>
                                        <th>@lang('app.Action')</th>
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

                                            <td>{{ $count }}</td>
                                            <td> {!! QrCode::size(100)->generate($order->order_id) !!} <br>
                                                <p class="text-center ;font-weight: bold;">{{ $order->order_id }}</p>
                                            </td>
                                            {{-- <td>
                                                <p> <span style="font-weight: bold;">form : </span> <span
                                                        style="">{{ !empty($order->user) ? $order->user->store_name : '' }}
                                                    </span> </p>
                                                <p><span style="font-weight: bold;">to : </span><span
                                                        style="">{{ $order->receved_name }}</span> </p>
                                                <p><span style="font-weight: bold;">tel : </span><span
                                                        style="">{{ $order->receved_phone }}</span></p>
                                                <p><span style="font-weight: bold;">COD : </span><span
                                                        style="">{{ $order->amount }} SAR</span></p>
                                            </td>
                                            <td width="30%">
                                                <p><span style="font-weight: bold; display:block">description : </span><span
                                                        style="">{{ $order->order_contents }}</span> </p>
                                                <p><span style="font-weight: bold; display:block">address : </span><span
                                                        style="">{{ $order->receved_address }}{{ $order->receved_address_2 }}</span>
                                                </p>
                                            </td>
                                            <td>signature
                                                <hr>
                                            </td>
                                            <td>name
                                                <hr>
                                            </td> --}}
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                                            <td>{{ !empty($order->senderCity) ? $order->senderCity->title : '' }}</td>
                                            <td>{{ $order->receved_name }}</td>
                                            <td>{{ $order->receved_phone }} <a href="tel:{{ $order->receved_phone }}"
                                                    style="padding:5px"><i class="fa fa-phone fa-2x"></i></a>
                                                <a href="https://api.whatsapp.com/send?phone={{ $order->receved_phone }}"
                                                    style="padding:5px"><i class="fa-brands fa-whatsapp fa-2x"
                                                        style="color:green"></i></a>
                                            </td>
                                            <td>{{ $order->amount }}</td>
                                            <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
                                                {{ $order->receved_address }} </td>
                                            <td style="    width:6%;">{{ $order->pickup_date }}</td>

                                            <td>{{ $order->number_count }}</td>

                                            <td style="    width: 10%;">{{ $order->updated_at }}</td>

                                            <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }}</td>
                                            <td>
                                                <a href="{{ route('delegate-orders.show', $order->id) }}" title="View"
                                                    class="btn btn-sm btn-info pull-right" style="margin: 2px;"><i
                                                        class="fa fa-eye"></i> <span
                                                        class="hidden-xs hidden-sm">@lang('app.Show_Policy')</span> </a>

                                                @if ($order->work_type == 1 && Auth()->user()->company_setting->status_shop != $order->status_id)
                                                    @if ($order->user != null)
                                                        @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
                                                            <!-- <a href="{{ route('delegate-orders.edit', $order->id) }}" title="change Status" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-refresh"></i> <span class="hidden-xs hidden-sm">@lang('app.change') @lang('app.status')</span> </a> -->
                                                        @endif
                                                    @endif
                                                @elseif($order->work_type == 2 && Auth()->user()->company_setting->status_res != $order->status_id)
                                                    @if ($order->user != null)
                                                        @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
                                                            <!-- <a href="{{ route('delegate-orders.edit', $order->id) }}" title="change Status" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-refresh"></i> <span class="hidden-xs hidden-sm">@lang('app.change') @lang('app.status')</span> </a> -->
                                                        @endif
                                                    @endif
                                                @endif

                                                <a class="btn btn-primary btn-sm" href="{{ $order->whatsapp_rate_link }}"
                                                    target="_blank"><i class="fa fa-star"></i> <span
                                                        class="hidden-xs hidden-sm"> @lang('app.Rate') </span> </a>
                                                <a href="{{ route('myOrder.comments', $order->id) }}" title="View"
                                                    class="btn btn-sm btn-success" style="margin: 2px;"><i
                                                        class="fa fa-commenting"></i> <span
                                                        class="hidden-xs hidden-sm">@lang('app.Comments')</span> </a>
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                  {!! $orders->appends(request()->query())->links() !!}
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th></th>
                                        <th></th>
                                        <th>#</th>
                                        <th></th>
                                        <th></th> --}}
                                        <th>@lang('app.Order_id')</th>
                                        <th>@lang('app.Store_Name') </th>
                                        <th>@lang('app.ship') @lang('app.from') </th>
                                        <th>@lang('app.Receved_Name')</th>
                                        <th>@lang('app.phone')</th>
                                        <th>@lang('app.amount')</th>
                                        <th>@lang('app.ship') @lang('app.to')</th>
                                        <th>@lang('app.ship_date')</th>
                                        <th>@lang('app.count')</th>
                                        <th>@lang('app.change') @lang('app.status')</th>
                                        <th>@lang('app.status')</th>
                                        <th>@lang('app.Action')</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
    </div><!-- /.row -->
    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')
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
            $('#example1').DataTable({
                retrieve: true,
                fixedColumns: true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                dom: 'lBfrtip',
                "columnDefs": [{
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [2],
                        "visible": false
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
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        "columnDefs": [{
                            "width": "20%",
                            "targets": 5
                        }]


                    },


                    {
                        extend: 'excelHtml5',
                        text: 'Export',
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
