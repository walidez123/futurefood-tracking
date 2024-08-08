@extends('layouts.master')
@section('pageTitle', 'Delegates Balances')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    @include('layouts._header-index', ['title' => $delegate->name, 'iconClass' => 'fa-money-bill', 'addUrl' => '',
    'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        @if (in_array('add_balance_delegate', app('User_permission')))
        <button type="button" class="btn btn-info pull-center" data-toggle="modal" data-target="#add-money">
            <i class="fa-solid fa-money-bill"></i>
            {{__('admin_message.Deposit')}}

        </button>
        <button type="button" class="btn btn-danger pull-center" data-toggle="modal" data-target="#add-money1">
            <i class="fa-solid fa-money-bill"></i>
            {{__('admin_message.withdraw')}}
        </button>
        @endif


        <div class="row">
            <div class="col-xs-8">
                <form action="{{route('delegates.transactions',[$delegate->id])}}" method="GET">

                    <div class="col-lg-3">
                        <label>@lang('admin_message.from')</label>
                        <input type="date" name="from" value="{{(isset($from))? $from : ''}}" class="form-control">
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <label for="to">@lang('admin_message.to') </label>
                            <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group ">

                            <!-- <option value="">@lang('admin_message.filter')</option> -->
                            <!-- <input type="submit" class="btn btn-block btn-primary" /> -->
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
                        <td>{{$count_debtor ? $count_debtor : '0'}}</td>
                    </tr>
                    <tr>
                    <th>{{ trans('admin_message.all_creditor') }}</th>
                        <td>{{$count_creditor ? $count_creditor : '0' }}</td>
                    </tr>
                    <tr>
                    <th>{{ trans('admin_message.order_debtor') }}</th>
                        <td>{{$count_order_debtor ? $count_order_debtor : '0' }}</td>
                    </tr>
                
                    <tr>
                        <th>{{ trans('admin_message.order_creditor') }}</th>
                        <td>{{$count_order_creditor ? $count_order_creditor : '0'}}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('admin_message.balance') }}</th>
                        <td>{{$count_creditor ? $count_creditor - $count_debtor : '0'}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">



                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"> 
                    
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable data_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('order.description') }}</th>
                                    <th>{{ trans('order.debtor') }}</th>
                                    <th>{{ trans('order.creditor') }}</th>
                                    <th>{{ trans('order.order') }}</th>
                                    <th>{{ trans('order.name') }}</th>
                                    <th>{{ trans('order.city') }}</th>
                                    <th>{{ trans('order.date') }}</th>
                                    <th>{{ trans('order.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1 ?>
                                @foreach ($alltransactions as $transaction)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$transaction->description}}</td>
                                    <!--  -->
                                    <td>{{$transaction->debtor}}</td>
                                    <td>{{$transaction->creditor}}</td>
                                    <td>@if(! empty($transaction->order) ) <a
                                            href="{{route('client-orders.show', $transaction->order->id)}}">{{ $transaction->order->order_id}}</a>@endif
                                    </td>
                                    <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif
                                    </td>
                                    <td>@if(! empty($transaction->order) && ! empty($transaction->order->recevedCity) )
                                        {{ $transaction->order->recevedCity->title}} @endif</td>
                                    <th>{{$transaction->created_at}}</th>
                                    <td>
                                        @if ( in_array('delete_balance_delegate', app('User_permission')))
                                        <form class="pull-right" style="display: inline;"
                                            action="{{route('transaction.destroy', $transaction->id)}}" method="POST">
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
                                <?php $count++ ?>
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
                                    <th>{{ trans('order.date') }}</th>
                                    <th>{{ trans('order.action') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $alltransactions->appends(Request::query())->links() }}
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
                <h4 class="modal-title">{{__('admin_message.Add Money To Account')}}</h4>
            </div>
            <form action="{{route('delegate.transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="debtor">
                    <input type="hidden" name="user_id" value="{{$delegate->id}}">

                    <div class="form-group">
                        <label for="name">{{__('admin_message.Amount')}}</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="debtor" required>
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('admin_message.Description')}}</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">{{__('admin_message.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
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
                <h4 class="modal-title">{{__('admin_message.Withdraw Money from Account')}}</h4>
            </div>
            <form action="{{route('delegate.transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="creditor">

                    <input type="hidden" name="user_id" value="{{$delegate->id}}">

                    <div class="form-group">
                        <label for="name">{{__('admin_message.Amount')}}</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="debtor" required>
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('admin_message.Description')}}</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">{{__('admin_message.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
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
        dom: 'lBfrtip',
        buttons: [

            'excel', 'print'
        ]
    });
});
</script>
@endsection