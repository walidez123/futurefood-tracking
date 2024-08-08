@extends('layouts.master')
@section('pageTitle', 'Delegates Balances')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => $delegate->name, 'iconClass' => 'fa-money-bill', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
      
      
      <div class="row">
      <div class="col-xs-8">
            <form action="{{route('delegates.transactions',[$delegate->id])}}" method="GET">
                              
                <div class="col-lg-2">
                    <label>From</label>
                    <input type="date" name="from" value="{{(isset($from))? $from : ''}}" class="form-control" >
                </div>
                <div class="col-lg-2">
                    <div class="form-group ">
                        <label for="to">To </label>
                        <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control" >
                    </div>
                </div>
               
                <div class="col-lg-2">
                    <div class="form-group ">
                       
                        <option value="">@lang('admin_message.filter')</option>
                        <input type="submit" class="btn btn-block btn-primary" />
                    </div>
                </div>
            </form>
    
        </div>
        <div class="col-xs-4">
            <table class=" table table-bordered table-striped ">
                <tr>
                    <th>All Debtor</th>
                    <td>{{$count_debtor ? $count_debtor : '0'}}</td>
                </tr>
                <tr>
                    <th>Order Debtor</th>
                    <td>{{$count_order_debtor ? $count_order_debtor : '0' }}</td>
                </tr>
                <tr>
                    <th>All Creditor</th>
                    <td>{{$count_creditor ? $count_creditor : '0' }}</td>
                </tr>
                <tr>
                    <th>Order Creditor</th>
                    <td>{{$count_order_creditor ? $count_order_creditor : '0'}}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{$count_creditor ? $count_creditor - $count_debtor : '0'}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped datatable data_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>description</th>
                  <th>Debtor </th>
                  <th>Creditor</th>
                  <th>order</th>
                  <th>name</th>
                  <th>city</th>
                  <th>date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($alltransactions as $transaction)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$transaction->description}}</td>
                  <td>{{$transaction->debtor}}</td>
                  <td>{{$transaction->creditor}}</td>
                  <td>@if(! empty($transaction->order) ) <a href="{{route('client-orders.show', $transaction->order->id)}}" >{{ $transaction->order->order_id}}</a>@endif </td>
                   <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif</td>
                  <td>@if(! empty($transaction->order) && ! empty($transaction->order->recevedCity) ) {{ $transaction->order->recevedCity->title}} @endif</td>
                    <th>{{$transaction->created_at}}</th>
                  <td>
                    @if($delegate->work==1)
                    @if (in_array('delete_balances', $permissionsTitle))
                        <form class="pull-right" style="display: inline;" action="{{route('transaction.destroy', $transaction->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                                  <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>
                              </form>
                    @endif
                    @else

                    @if (in_array('delete_balance_res', $permissionsTitle))
                        <form class="pull-right" style="display: inline;" action="{{route('transaction.destroy', $transaction->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                                  <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>
                              </form>
                    @endif



                    @endif
                        
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                        <th>#</th>
                        <th>description</th>
                        <th>Debtor</th>
                        <th>Creditor</th>
                        <th>order</th>
                         <th>name</th>
                  <th>city</th>
                  <th>date</th>
                  <th>Action</th>
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
            $('#example1').DataTable( {
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },

                retrieve: true,
                fixedColumns:   true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength : 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection