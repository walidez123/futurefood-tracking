@extends('layouts.master')
@section('pageTitle', trans('admin_message.orderspickup'))
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
                                <div class="row ">
                                    @if (in_array('add_pickup_order', $permissionsTitle))
                                        <a type="button"
                                            href="{{ route('client-orders.create', ['work_type' => $work_type]) }}"
                                            class="btn btn-success">
                                            {{ __('admin_message.Add') }} <i class="fa-solid fa-plus"></i></a>
                                    @endif

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal">
                                        {{ __('admin_message.Search and filter') }} </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <form action="{{ route('pickup-orders.index') }}" method="GET"
                                                        class="col-xs-12">
                                                        <input type="hidden" name="work_type" value="{{ $work_type }}">
                                                        <input type="hidden" name="type" value="ship">

                                                        <div class="col-lg-6">
                                                            @if ($work_type == 1)
                                                            <label>{{ __('admin_message.Clients') }}</label>
                                                            @else
                                                                <label>{{ __('order.sender_name') }}</label>
                                                            @endif
                                                            <select class="form-control select2" name="user_id">
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
                                                                    <option
                                                                        {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                                        value="{{ $client->id }}">{{ $client->name }} |
                                                                        {{ $client->store_name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.statuses') }}</label>
                                                            <select class="form-control select2" name="status_id">
                                                                <option value="">
                                                                    {{ __('admin_message.Choose a statuses') }}</option>
                                                                @foreach ($statuses as $status)
                                                                    <option
                                                                        {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                                        value="{{ $status->id }}">
                                                                        {{ $status->trans('title') }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.The delegates') }}</label>
                                                            <select class="form-control select2" name="delegate_id">
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

                                                        <div class="col-lg-6">
                                                        <label>{{ __('admin_message.PaidOrNot') }}</label>
                                                            <select class="form-control select2" name="paid">
                                                            <option value="">{{ __('admin_message.select') }}
                                                                </option>
                                                                <option
                                                                {{ isset($paid) && $paid == 1 ? 'selected' : '' }}
                                                                value="1">{{ __('admin_message.Paid') }}</option>
                                                            <option
                                                                {{ isset($paid) && $paid == 0 ? 'selected' : '' }}
                                                                value="0">{{ __('admin_message.UnPaid') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.from') }}</label>
                                                            <input type="date" name="from"
                                                                value="{{ isset($from) ? $from : '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group ">
                                                                <label for="to">{{ __('admin_message.to') }}</label>
                                                                <input type="date" name="to"
                                                                    value="{{ isset($to) ? $to : '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.from city') }}</label>
                                                            <select class="form-control select2 col-md-12"
                                                                name="sender_city">
                                                                <option value="">
                                                                    {{ __('admin_message.Select a city') }}</option>
                                                                @if (!empty($cities))
                                                                    @foreach ($cities as $city)
                                                                        <option
                                                                            {{ isset($sender_city) && $sender_city == $city->id ? 'selected' : '' }}
                                                                            value="{{ $city->id }}">
                                                                            {{ $city->trans('title') }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.to city') }}</label>
                                                            <select class="form-control select2" name="receved_city">
                                                                <option value="">{{ __('admin_message.from city') }}
                                                                </option>
                                                                @if (!empty($cities))
                                                                    @foreach ($cities as $city)
                                                                        <option
                                                                            {{ isset($receved_city) && $receved_city == $city->id ? 'selected' : '' }}
                                                                            value="{{ $city->id }}">
                                                                            {{ $city->trans('title') }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                        <!-- service provider -->
                                                        <div class="col-lg-6">
                                                            <label>{{ __('admin_message.Service provider') }}</label>
                                                            <select class="form-control select2" name="service_provider_id">
                                                                <option value="">
                                                                    {{ __('admin_message.Choose a  Service Provider') }}
                                                                </option>
                                                                @if (!empty($service_providers))
                                                                    @foreach ($service_providers as $service_provider)
                                                                        <option
                                                                            {{ isset($service_provider_id) && $service_provider_id == $service_provider->serviceProvider->id ? 'selected' : '' }}
                                                                            value="{{ $service_provider->serviceProvider->id }}">
                                                                            {{ $service_provider->serviceProvider->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
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


                        </div>

                        <div class="box">
                            <div class="box-header">

                                <div class="col-sm-12 invoice-col">
                                    @if (in_array('change_status', $permissionsTitle))

                                        <div class="col-md-6">
                                            <form action="{{ route('order.change_status_all') }}" method="POST">
                                                <td><input type="hidden" name="order_id[]" value=""
                                                        id="ordersId"></td>
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group col-md-8 ">
                                                    <select class="form-control select2" id="status_id" name="status_id"
                                                        required>
                                                        <option value="">
                                                            {{ __('admin_message.Choose a statuses') }}</option>
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}">
                                                                {{ $status->trans('title') }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <input type="submit" class="btn btn-success"
                                                        value="{{ __('admin_message.Status change') }}">

                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                    @if (in_array('distribution_order', $permissionsTitle))


                                        <div class="col-md-6">
                                            <form action="{{ route('pickuporders.distribute') }}" method="POST">

                                                <td><input type="hidden" name="orders[]" value=""
                                                        id="passordersId">
                                                    <input type="hidden" name="type" value="data">
                                                </td>
                                                @csrf

                                                <div class="col-md-8">
                                                    <!-- <label>{{ __('admin_message.Delegates') }}</label> -->
                                                    <select class="form-control select2" name="delegate_id" required>
                                                        <option value="">{{ __('admin_message.Choose a Delegate') }}
                                                        </option>
                                                        @foreach ($delegates as $delegate)
                                                            <option value="{{ $delegate->id }}">{{ $delegate->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <!-- <label>{{ __('admin_message.Assign To Delegate') }} </label> -->
                                                    <input type="submit" class="btn btn-success btn-block"
                                                        value="{{ __('admin_message.Assign To Delegate') }}">
                                                </div>

                                            </form>

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-12">
                                <form action="{{ route('pickup-orders.index') }}" method="get" id="search-form" />
                                <input type="hidden" name="type" value="ship">
                                <input type="hidden" name="work_type" value="{{ $work_type }}">


                                <div class="col-md-3 col-sm-3">
                                    <div id="imaginary_container">
                                        <div class="input-group stylish-input-group">
                                            <input type="text" class="form-control" id="search-field"
                                                value="{{ !empty($search) ? $search : '' }}" name="search"
                                                placeholder="{{ __('admin_message.Quick search') }}">
                                            <span class="input-group-addon">
                                                <button type="submit" id="search-btn1">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                </form>


                                <form action="{{ route('pickup-orders.index') }}" method="get" id="search-form" />
                                <input type="hidden" name="type" value="ship">
                                <input type="hidden" name="work_type" value="{{ $work_type }}">



                                <div class="col-md-3 col-sm-3">
                                    <div id="imaginary_container">
                                        <div class="input-group stylish-input-group">
                                            <input type="text" class="form-control" id="search-field"
                                                value="{{ !empty($search_order) ? $search_order : '' }}"
                                                name="search_order"
                                                placeholder="{{ __('admin_message.Quick search for a group of requests') }}">
                                            <span class="input-group-addon">
                                                <button type="submit" id="search-btn1">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                </form>
                               
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
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>{{ __('admin_message.Order Number') }}</th>
                                            <th width="20%">#</th>
                                            <th width="30%">#</th>
                                            <th width="25%"></th>
                                            <th width="25%"></th>
                                            <th>
                                                @if ($work_type == 2)
                                                    <label>{{ __('admin_message.restaurants') }}</label>
                                                @else
                                                    <label>{{ __('order.sender_name') }}</label>
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
                                            <th>{{ __('admin_message.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($orders as $order)
                                            <tr>
                                                @if ($order->work_type == 1)
                                                    @if (Auth()->user()->company_setting != null && Auth()->user()->company_setting->status_shop == $order->status_id)
                                                        <td><input disabled type="checkbox" name="orders[]"
                                                                value="{{ $order->id }}" class="ordersId"></td>
                                                    @else
                                                        <td><input type="checkbox" name="orders[]"
                                                                value="{{ $order->id }}" class="ordersId"></td>
                                                    @endif
                                                @else
                                                    @if (Auth()->user()->company_settin != null && Auth()->user()->company_setting->status_res == $order->status_id)
                                                        <td><input disabled type="checkbox" name="orders[]"
                                                                value="{{ $order->id }}" class="ordersId"></td>
                                                    @else
                                                        <td><input type="checkbox" name="orders[]"
                                                                value="{{ $order->id }}" class="ordersId"></td>
                                                    @endif
                                                @endif

                                                <td>{{ $count }}</td>
                                                <td> {!! QrCode::size(100)->generate($order->order_id) !!} <br>
                                                    <p class="text-center ;font-weight: bold;">{{ $order->order_id }}</p>
                                                </td>
                                                <td>
                                                    <p> <span style="font-weight: bold;">form : </span> <span
                                                            style="">{{ $order->user?->store_name }} </span> </p>
                                                    <p><span style="font-weight: bold;">to : </span><span
                                                            style="">{{ $order->receved_name }}</span> </p>
                                                    <p><span style="font-weight: bold;">tel : </span><span
                                                            style="">{{ $order->receved_phone }}</span></p>
                                                    <p><span style="font-weight: bold;">COD : </span><span
                                                            style="">{{ $order->amount }} SAR</span></p>
                                                </td>
                                                <td width="30%">
                                                    <p><span style="font-weight: bold; display:block">description :
                                                        </span><span style="">{{ $order->order_contents }}</span>
                                                    </p>
                                                    <p><span style="font-weight: bold; display:block">address :
                                                        </span><span
                                                            style="">{{ $order->receved_address }}{{ $order->receved_address_2 }}</span>
                                                    </p>
                                                </td>
                                                <td>signature
                                                    <hr>
                                                </td>
                                                <td>name
                                                    <hr>
                                                </td>

                                                <td>{{ !empty($order->user) ? $order->user?->store_name : '' }}</td>
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

                                                <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }}
                                                    <br>
                                                    {{ $order->updated_at }}</td>

                                                <td>{{ !empty($order->delegate_pickup) ? $order->delegate_pickup->name : '' }}
                                                </td>
                                                <td> @if(!empty($order->service_provider))
                        {{$order->service_provider->name}} 
                    @else
                        @include('admin.orders.service_provider')
                    @endif
                                                </td>

                                                <td>

                                                    <a href="{{ url('/admin/order-notifications/' . $order->id) }}"
                                                        class="btn btn-sm {{ $order->notification_no > 0 ? 'btn-warning' : 'btn-default' }}"
                                                        style="margin: 2px;"><i
                                                            class="fa fa-bell"></i><span>({{ $order->notification_no }})</span></a>
                                                    @if ($work_type == 1)
                                                        @if (in_array('show_pickup_order', $permissionsTitle))
                                                            <a href="{{ route('client-orders.show', $order->id) }}"
                                                                title="View" class="btn btn-sm btn-warning"
                                                                style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span>
                                                            </a>
                                                        @endif
                                                        @if (in_array('show_history_order', $permissionsTitle))
                                                            <a href="{{ route('client-orders.history', $order->id) }}"
                                                                title="History" class="btn btn-sm btn-success"
                                                                style="margin: 2px;"><i class="fa fa-history fa-spin"></i>
                                                                <span
                                                                    class="hidden-xs hidden-sm">{{ __('admin_message.History') }}</span>
                                                            </a>
                                                        @endif

                                                        @if (in_array('delete_pickup_order', $permissionsTitle))
                                                            <form class="pull-right" style="display: inline;"
                                                                action="{{ route('client-orders.destroy', $order->id) }}"
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
                                                        <br>
                                                        @if (in_array('send_rate_order', $permissionsTitle))
                                                            <a class="btn btn-primary btn-sm"
                                                                href="{{ $order->whatsapp_rate_link }}"
                                                                target="_blank"><i class="fa fa-star"></i> <span
                                                                    class="hidden-xs hidden-sm">
                                                                    {{ __('admin_message.Rate') }} </span> </a>
                                                        @endif
                                                        @if (in_array('edit_pickup_order', $permissionsTitle))
                                                            <a href="{{ route('client-orders.edit', $order->id) }}"
                                                                title="View" class="btn btn-sm btn-info"
                                                                style="margin: 2px;"><i class="fa fa-edit"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span>
                                                            </a>
                                                        @endif
                                                    @endif



                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <th>#</th>
                                            <th>#</th>
                                            <th>{{ __('admin_message.Order Number') }}</th>
                                            <th width="20%">#</th>
                                            <th width="30%">#</th>
                                            <th width="25%"></th>
                                            <th width="25%"></th>
                                            <th>
                                                @if ($work_type == 2)
                                                    <label>{{ __('admin_message.restaurants') }}</label>
                                                @else
                                                    <label>{{ __('order.sender_name') }}</label>
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
                                            <th>{{ __('admin_message.Action') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><!-- /.box-body -->

                            {!! $orders->appends($_GET)->links() !!}

                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script></script>
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

            });
            $(".ordersId").on('change', function() {
                var arr = [];
                $('input:checkbox:checked').each(function() {
                    arr.push($(this).val());
                });

                $('#ordersId').val(arr)

                $('#passordersId').val(arr)
                $('#serviceordersId').val(arr)



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
                            columns: [0, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
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
