@extends('layouts.master')
@section('pageTitle', 'Clients Balances')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('layouts._header-index', [
            'title' => $client->name,
            'iconClass' => 'fa-user',
            'addUrl' => '',
            'multiLang' => 'false',
        ])
        <style>
            .paging_simple_numbers {
                display: none !important;
            }
        </style>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="box-header">
                    <h3 class="box-title">
                        <button type="button" class="btn btn-info pull-center" data-toggle="modal" data-target="#add-money">
                            <i class="fa-solid fa-dollar-sign"></i>
                            @lang('balance.Deposit')
                        </button>
                        <button type="button" class="btn btn-danger pull-center" data-toggle="modal"
                            data-target="#add-money1">
                            <i class="fa-solid fa-dollar-sign"></i>
                            @lang('balance.withdraw')
                        </button>
                    </h3>
                </div><!-- /.box-header -->
                <div class="col-xs-8">
                    <form action="{{ route('clients.transactions', [$client->id]) }}" method="GET">
                        <div class="col-lg-4">
                            <label>@lang('admin_message.from')</label>
                            <input type="date" name="from" value="{{ isset($from) ? $from : '' }}"
                                class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="to">@lang('admin_message.to') </label>
                                <input type="date" name="to" value="{{ isset($to) ? $to : '' }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group ">

                                <button type="submit" class="btn btn-block btn-primary" name="action" value="filter">@lang('admin_message.filter')</button>
                               <button type="submit" style="background-color:#ed1b2f;border-radius: unset; width:auto !important;" class=" btn-block btn-danger btn"  name="action" value="export">Export To Excel</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-xs-4">
                    <table class=" table table-bordered table-striped ">
                        <tr>
                            <th>{{ trans('admin_message.all_debtor') }}</th>
                            <td>{{ $count_debtor }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin_message.all_creditor') }}</th>
                            <td>{{ $count_creditor }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin_message.order_debtor') }}</th>
                            <td>{{ $count_order_creditor }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin_message.order_creditor') }}</th>
                            <td>{{ $count_order_debtor }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin_message.balance') }}</th>
                            <td>{{ $count_debtor - $count_creditor }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-12">
                    @if ($client->work == 4)
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#balances" data-toggle="tab" aria-expanded="true"><i
                                        class="fa fa-shop"></i>{{ __('app.order_balances') }}</a></li>
                            <li class=""><a href="#pallet_balances" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa fa-usd"></i>{{ __('app.pallet_balances') }}</a></li>
                        </ul>
                    @endif

                    {{-- @if ($client->work == 2)
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#balances" data-toggle="tab" aria-expanded="true"><i
                                        class="fa fa-shop"></i>{{ __('app.COD_balances') }}</a></li>
                            <li class=""><a href="#chipments_balances" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa fa-usd"></i>{{ __('app.chipments_balances') }}</a></li>
                        </ul>
                    @endif --}}
                    

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        {{-- @if($client->work != 2) --}}
                        <div class="box-body tab-pane active" id="balances">
                            <table id="account" class="data_table  datatable table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($alltransactions->currentPage()==1){
                                            $count = 1; 

                                        }else{
                                            $count=(($alltransactions->currentPage()-1)*200)+1;
                                        }
                                    ?> 
                                    @foreach ($alltransactions as $transaction)
                                        <tr>
                                            <td>{{ $count }}</td>
                                          
                                             <td>{{$transaction->description}}</td>
                                            <td>{{ $transaction->debtor }}</td>
                                            <td>{{ $transaction->creditor }}</td>
                                            <td>@if(! empty($transaction->order) ) <a href="{{route('client-orders.show', $transaction->order->id)}}" >{{ $transaction->order->order_id}}</a> @endif</td>
                                            <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif</td>
                                            <td>@if(! empty($transaction->order) && ! empty($transaction->order->recevedCity) ) {{ $transaction->order->recevedCity->title}} @endif</td>
                                            <th>
                                                @if($transaction->image!=NULL)
                                                <img src="{{asset('storage/avatar/transactions/'.$transaction->image)}}" height="75" width="120">
                                                @endif
                                            </th>
                                            <th>{{ $transaction->created_at }}</th>
                                            <td>
                                                @if (
                                                    ($client->work == 1 && in_array('delete_balances', app('User_permission'))) ||
                                                        ($client->work == 2 && in_array('delete_balance_res', app('User_permission'))) ||
                                                        ($client->work == 3 && in_array('delete_balance_warehouse', app('User_permission'))) ||
                                                        ($client->work == 4 && in_array('delete_balance_fulfillment', app('User_permission'))))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('transaction.destroy', $transaction->id) }}"
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
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $alltransactions->appends(Request::query())->links() }}
                        </div><!-- /.box-body -->
                        {{-- @else

                        <div class="box-body tab-pane active" id="COD_balances">
                            <table id="example1" class="data_table  datatable table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($cod_transactions->currentPage()==1){
                                            $count = 1; 

                                        }else{
                                            $count=(($cod_transactions->currentPage()-1)*50)+1;
                                        }
                                    ?> 
                                    @foreach ($cod_transactions as $transaction)
                                        <tr>
                                            <td>{{ $count }}</td>
                                          
                                             <td>{{$transaction->description}}</td>
                                            <td>{{ $transaction->debtor }}</td>
                                            <td>{{ $transaction->creditor }}</td>
                                            <td>@if(! empty($transaction->order) ) <a href="{{route('client-orders.show', $transaction->order->id)}}" >{{ $transaction->order->order_id}}</a> @endif</td>
                                            <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif</td>
                                            <td>@if(! empty($transaction->order) && ! empty($transaction->order->recevedCity) ) {{ $transaction->order->recevedCity->title}} @endif</td>
                                            <th>
                                                @if($transaction->image!=NULL)
                                                <img src="{{asset('storage/avatar/transactions/'.$transaction->image)}}" height="75" width="120">
                                                @endif
                                            </th>
                                            <th>{{ $transaction->created_at }}</th>
                                            <td>
                                                @if (
                                                    ($client->work == 1 && in_array('delete_balances', app('User_permission'))) ||
                                                        ($client->work == 2 && in_array('delete_balance_res', app('User_permission'))) ||
                                                        ($client->work == 3 && in_array('delete_balance_warehouse', app('User_permission'))) ||
                                                        ($client->work == 4 && in_array('delete_balance_fulfillment', app('User_permission'))))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('transaction.destroy', $transaction->id) }}"
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
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $cod_transactions->appends(Request::query())->links() }}
                        </div>


                        <div class="box-body tab-pane active" id="chipments_balances">
                            <table id="example1" class="data_table  datatable table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($chipment_transactions->currentPage()==1){
                                            $count = 1; 

                                        }else{
                                            $count=(($chipment_transactions->currentPage()-1)*50)+1;
                                        }
                                    ?> 
                                    @foreach ($chipment_transactions as $transaction)
                                        <tr>
                                            <td>{{ $count }}</td>
                                          
                                             <td>{{$transaction->description}}</td>
                                            <td>{{ $transaction->debtor }}</td>
                                            <td>{{ $transaction->creditor }}</td>
                                            <td>@if(! empty($transaction->order) ) <a href="{{route('client-orders.show', $transaction->order->id)}}" >{{ $transaction->order->order_id}}</a> @endif</td>
                                            <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif</td>
                                            <td>@if(! empty($transaction->order) && ! empty($transaction->order->recevedCity) ) {{ $transaction->order->recevedCity->title}} @endif</td>
                                            <th>
                                                @if($transaction->image!=NULL)
                                                <img src="{{asset('storage/avatar/transactions/'.$transaction->image)}}" height="75" width="120">
                                                @endif
                                            </th>
                                            <th>{{ $transaction->created_at }}</th>
                                            <td>
                                                @if (
                                                    ($client->work == 1 && in_array('delete_balances', app('User_permission'))) ||
                                                        ($client->work == 2 && in_array('delete_balance_res', app('User_permission'))) ||
                                                        ($client->work == 3 && in_array('delete_balance_warehouse', app('User_permission'))) ||
                                                        ($client->work == 4 && in_array('delete_balance_fulfillment', app('User_permission'))))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('transaction.destroy', $transaction->id) }}"
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
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.creditor') }}</th>
                                        <th>{{ trans('order.order') }}</th>
                                        <th>{{ trans('order.name') }}</th>
                                        <th>{{ trans('order.city') }}</th>
                                        <th>{{ trans('order.image') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $chipment_transactions->appends(Request::query())->links() }}
                        </div>

                        
                        @endif
                   --}}
                                       

                        @if ($client->work == 4)
                        <div class="box-body ">
                        
                            <table id="example2" class="data_table  datatable table table-bordered table-striped tab-pane"
                                id="">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('app.Shelf') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('app.subscription_type') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($pallet_subscriptions->currentPage()==1){
                                            $count = 1; 

                                        }else{
                                            $count=(($pallet_subscriptions->currentPage()-1)*50)+1;
                                        }
                                    ?> 
                                    @foreach ($pallet_subscriptions as $transaction)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                               
                                                {{ $transaction->description }}
                                            </td>
                                            <td>{{ $transaction->cost }}</td>
                                            <td>{{ $transaction->clientPackagesGoods->package->title }}</td>
                                            <th>{{ $transaction->start_date }}</th>
                                            <th>{{ $transaction->type == 'daily' ? 'يومي' : 'شهري' }}</th>
                                            <td>
                                                <form class="pull-right" style="display: inline;"
                                                    action="{{ route('pallet-subscriptions.destroy', $transaction->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you want Delete This Record ?');">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('app.Shelf') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('app.subscription_type') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $pallet_subscriptions->appends(Request::query())->links() }}

                            </div>
                            <div class="box-body ">
        
                            <table id="example2" class="data_table  datatable table table-bordered table-striped tab-pane"
                                id="pallet_balances">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.order_id') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    if($pallet_recives->currentPage()==1){
                                        $count = 1; 

                                    }else{
                                        $count=(($pallet_recives->currentPage()-1)*50)+1;
                                    }
                                ?>
                                    @foreach ($pallet_recives as $transaction)
                                        <tr>
                                        <td>{{ $count }}</td>
                                        <td>
                                                {{ $transaction->description }}
                                        </td>
                                        <td>{{ $transaction->cost }}</td>
                                        <td>@if(! empty($transaction->pickupOrder) ) <a href="{{route('client_orders_pickup.show',  $transaction->pickupOrder->id)}}" >{{ $transaction->pickupOrder->order_id}}</a> @endif</td>
                                        <th>{{ $transaction->start_date }}</th>
                                        <td>
                                                <form class="pull-right" style="display: inline;"
                                                    action="{{ route('pallet-subscriptions.destroy', $transaction->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you want Delete This Record ?');">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
                                        <th>{{ trans('order.description') }}</th>
                                        <th>{{ trans('order.debtor') }}</th>
                                        <th>{{ trans('order.order_id') }}</th>
                                        <th>{{ trans('order.date') }}</th>
                                        <th>{{ trans('order.action') }}</th>

                                    </tr>
                                </tfoot>
                            </table>
                            {{ $pallet_recives->appends(Request::query())->links() }}

                        @endif
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <div class="modal fade" id="add-money">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('balance.Add Money To Client Account')</h4>
                </div>
                <form action="{{ route('transaction.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="debtor">
                        <input type="hidden" name="user_id" value="{{ $client->id }}">
                        <div class="form-group">
                            <label for="name">@lang('balance.Amount')</label>
                            <input style="width:100%" type="number" min="1" step="any" name="amount"
                                id="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="name">@lang('balance.Description')</label>
                            <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                        </div>
                        <input type="file" class="form-control" id="image" placeholder="Image"
                                name="image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left"
                            data-dismiss="modal">@lang('balance.Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('balance.Deposit')</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <div class="modal fade" id="add-money1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('balance.Add Money To Client Account')</h4>
                </div>
                <form action="{{ route('transaction.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="creditor">
                        <input type="hidden" name="user_id" value="{{ $client->id }}">
                        <div class="form-group">
                            <label for="name">@lang('balance.Amount')</label>
                            <input style="width:100%" type="number" min="1" step="any" name="amount"
                                id="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="name">@lang('balance.Description')</label>
                            <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">ارفق صورة</label>
                            <input type="file" class="form-control" id="image" placeholder="Image"
                                name="image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left"
                            data-dismiss="modal">@lang('balance.Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('balance.withdraw')</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#account').DataTable({
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },

                retrieve: true,
                fixedColumns: true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength: 200,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            });
        });

        $('#example2').DataTable({
            retrieve: true,
            fixedColumns: true,
            dom: 'Bfrtip',
            direction: "rtl",
            charset: "utf-8",
            direction: "ltr",
            pageLength: 200,
            dom: 'lBfrtip',
            buttons: [

                'excel', 'print'
            ]
        });
    </script>
@endsection
