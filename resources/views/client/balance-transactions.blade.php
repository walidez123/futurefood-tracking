@extends('layouts.master')
@section('pageTitle', 'Clients Balances')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection
<style>
    .dataTables_paginate{
        display: none !important;
    }
    </style>

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
          
  @include('layouts._header-index', ['title' => __('app.transactions', ['attribute' => __('app.balance', ['attribute' => '' ])]), 'iconClass' => 'fa-money-bill', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content bg-white" style="margin-top:10px">
    <div class="row">
      <div class="col-xs-12">

      </div>
      <div class="col-xs-12">
            <form action="{{route('transactions.client')}}" method="GET">
                              
                <div class="col-lg-4">
                    <label>@lang('order.from_date')</label>
                    <input type="date" name="from" value="{{(isset($from))? $from : ''}}" class="form-control" >
                </div>
                <div class="col-lg-4">
                    <div class="form-group ">
                        <label for="to">@lang('order.to_date') </label>
                        <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control" >
                    </div>
                </div>
               
                <div class="col-lg-4">
                    <div class="form-group ">
                       
                        <label></label>
                        <!-- <input type="submit" class="btn btn-block btn-primary"  value="فلتر"/> -->
                        <button type="submit" class="btn btn-block btn-primary" name="action" value="filter">@lang('admin_message.filter')</button>
                        <button type="submit" style="" class=" btn-block btn-danger btn"  name="action" value="export">Export To Excel</button>
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
                    <th>All Creditor</th>
                    <td>{{$count_creditor ? $count_creditor : '0'}}</td>
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
        @if ($client->work == 4)
            <ul class="nav nav-tabs">
                <li class="active"><a href="#balances" data-toggle="tab" aria-expanded="true"><i
                            class="fa fa-shop"></i>{{ __('app.order_balances') }}</a></li>
                <li class=""><a href="#pallet_balances" data-toggle="tab" aria-expanded="false"><i
                            class="fa fa fa-usd"></i>{{ __('app.pallet_balances') }}</a></li>
            </ul>
        @endif
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="account" class="table table-bordered table-striped datetable dataTables_wrapper datatable data_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>@lang('app.detials', ['attribute' => ''])</th>
                  <th>@lang('app.debtor')</th>
                  <th>@lang('app.creditor')</th>
                  <th>@lang('app.order', ['attribute' => ''])</th>
                   <th>الاسم</th>
                  <th>@lang('app.date')</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    if($transactions->currentPage()==1){
                        $count = 1; 

                    }else{
                        $count=(($transactions->currentPage()-1)*200)+1;
                    }
                ?>
                @foreach ($transactions as $transaction)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$transaction->description}}</td>
                  <td>{{$transaction->debtor}}</td>
                  <td>{{$transaction->creditor}}</td>
                  <td>@if(! empty($transaction->order) ) <a href="orders/{{ $transaction->order->id}}" >{{ $transaction->order->order_id}}</a> @endif</td>
                                    <td>@if(! empty($transaction->order) ) {{ $transaction->order->receved_name}} @endif</td>
                    <td>{{$transaction->dateFormatted() }}</td>

                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>@lang('app.detials', ['attribute' => ''])</th>
                    <th>@lang('app.debtor')</th>
                    <th>@lang('app.creditor')</th>
                    <th>@lang('app.order', ['attribute' => ''])</th>
                     <th>الاسم</th>
                    <th>@lang('app.date')</th>
                </tr>
              </tfoot>
            </table>
            {{ $transactions->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
          <div class="box-body ">
            @if ($client->work == 4)
              <table id="example2" class="data_table  datatable table table-bordered table-striped tab-pane"
                  id="pallet_balances">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>{{ trans('order.description') }}</th>
                          <th>{{ trans('order.debtor') }}</th>
                          <th>{{ trans('app.Shelf') }}</th>
                          <th>{{ trans('order.date') }}</th>
                          <th>{{ trans('app.subscription_type') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php 
                        if($pallet_subscriptions->currentPage()==1){
                            $count = 1; 

                        }else{
                            $count=(($pallet_subscriptions->currentPage()-1)*200)+1;
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
                      </tr>
                  </thead>
                  <tbody>
                    <?php 
                        if($pallet_recives->currentPage()==1){
                            $count = 1; 

                        }else{
                            $count=(($pallet_recives->currentPage()-1)*200)+1;
                        }
                    ?>
                      @foreach ($pallet_recives as $transaction)
                          <tr>
                            <td>{{ $count }}</td>
                            <td>
                                  {{ $transaction->description }}
                            </td>
                            <td>{{ $transaction->cost }}</td>
                            <td>@if(! empty($transaction->pickupOrder) ) <a href="orders_pickup/{{ $transaction->pickupOrder->id}}" >{{ $transaction->pickupOrder->order_id}}</a> @endif</td>
                            <th>{{ $transaction->start_date }}</th>
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
                      </tr>
                  </tfoot>
              </table>
              {{ $pallet_recives->appends(Request::query())->links() }}
            @endif  
          </div>
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
    </script>
@endsection
