@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))

@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">

                        <div class="tab-content">
                            <div class="active tab-pane" id="filter1">
                                <div class="row ">
                                    <table id="order"
                                        class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin_message.Order Number') }}</th>
                                                <th>
                                                    <label>{{ __('order.sender_name') }}</label>
                                                </th>
                                                <th>{{ __('order.delivery_city') }} </th>
                                                <th>{{ __('order.received_name') }}</th>
                                                <th>{{ __('order.received_phone') }}</th>
                                                <th>{{ __('order.amount') }}</th>
                                                <th>{{ __('order.ship_to') }}</th>
                                                <th>{{ __('admin_message.reference_number') }}</th>
                                                <th>{{ __('admin_message.status') }}</th>
                                                <th>{{ __('admin_message.Delegate') }}</th>
                                                <th>{{ __('admin_message.Service provider') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 1; ?>
                                            @foreach ($orders as $order)
                                                <tr>

                                                    <td>{{ $count }}</td>
                                                    <td>
                                                        <p class="text-center ;font-weight: bold;">{{ $order->order_id }}
                                                        </p>
                                                    </td>


                                                    <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                                                    <td>{{ !empty($order->senderCity) ? $order->senderCity->trans('title') : '' }}
                                                    </td>
                                                    <td>{{ $order->receved_name }}</td>
                                                    <td>{{ $order->receved_phone }} <a
                                                            href="tel:{{ $order->receved_phone }}" style="padding:5px"><i
                                                                class="fa fa-phone fa-2x"></i></a>
                                                    </td>
                                                    <th>
                                                        @if ($order->amount_paid == 0)
                                                            <span style="color: rgb(182, 33, 33);">{{ $order->amount }}</span>
                                                        @else
                                                            <span style="color: green;">{{ $order->amount }}</span>
                                                        @endif
                                                    </th>
                                                    <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
                                                    </td>
                                                    <td>{{ $order->reference_number }}</td>

                                                    <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }}
                                                        <br>
                                                        {{ $order->updated_at }}
                                                    </td>

                                                    <td>
                                                        {{ !empty($order->delegate) ? $order->delegate->name : '' }}

                                                    </td>
                                                    <td>{{ !empty($order->service_provider) ? $order->service_provider->name : '' }}
                                                    </td>
                                                </tr>
                                                <?php $count++; ?>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin_message.Order Number') }}</th>
                                                <th>
                                                    <label>{{ __('order.sender_name') }}</label>

                                                </th>
                                                <th>{{ __('order.delivery_city') }} </th>
                                                <th>{{ __('order.received_name') }}</th>
                                                <th>{{ __('order.received_phone') }}</th>
                                                <th>{{ __('order.amount') }}</th>
                                                <th>{{ __('order.ship_to') }}</th>
                                                <th>{{ __('admin_message.reference_number') }}</th>
                                                <th>{{ __('admin_message.status') }}</th>
                                                <th>{{ __('admin_message.Delegate') }}</th>
                                                <th>{{ __('admin_message.Service provider') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    @endsection
    @section('js')
    
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
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
        $('#order').DataTable({
            retrieve: true,
            fixedColumns: true,
            dom: 'Bfrtip',
            direction: "rtl",
            charset: "utf-8",
            direction: "ltr",
            scrollX: true,
            lengthMenu: [[50, 100, -1], [50, 100, "All"]],
            pageLength: 50,
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: false,
                    text: 'Export', 
                   
                }
            ]
    
        });
    
    });
    
    </script>
    
    @endsection