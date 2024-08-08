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
                    @if(session('success'))
                    <div id="success-alert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
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
                                <form action="{{ route('orderDerlivaryReport.index') }}" method="get"
                                    class="col-xs-12">

                                    <input type="hidden" name="work_type" value="{{ $work_type }}">
                                    <input type="hidden" name="type" value="ship">

                                    <div class="col-lg-4">
                                        @if ($work_type == 1)
                                        <label>{{ __('admin_message.Clients') }}</label>
                                        @elseif($work_type == 4)
                                        <label>{{ __('fulfillment.fulfillment_clients') }}</label>

                                        @else
                                        <label>{{ __('admin_message.restaurants') }}</label>
                                        @endif
                                        <select class="form-control select2" name="user_id">
                                            @if ($work_type == 1)
                                            <option value="">
                                                {{ __('admin_message.Choose a store') }}</option>
                                            </option>
                                            @elseif ($work_type == 4)
                                            <option value="">
                                                {{ __('admin_message.Choose a fulfillment') }}
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





                                    <div class="col-lg-4">
                                        <label>{{ __('admin_message.from') }}</label>
                                        <input type="date" name="from" value="{{ isset($from) ? $from : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label for="to">{{ __('admin_message.to') }}</label>
                                            <input type="date" name="to" value="{{ isset($to) ? $to : '' }}"
                                                class="form-control">
                                        </div>
                                    </div>


                            </div>
                            <div class="modal-footer">

                                <div class="col-lg-6">
                                    <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                        value="{{ __('admin_message.filter') }}" />
                                </div>


                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table id="order" class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
 
 <thead>
     <tr>
         <th>#</th>
         <th>{{ __('admin_message.Order Number') }}</th>
         <th>
           <label>{{ __('order.received_name') }}</label>
         </th>
         <th>{{ __('admin_message.reference_number') }}</th>
         <th>{{ __('admin_message.branch') }}</th>

         <th>{{ __('admin_message.Delegate') }}</th>

         <th>{{ __('admin_message.received Order') }}</th>
         <th>{{ __('admin_message.Delivered order') }}</th>
     </tr>
 </thead>
 <tbody>
    @isset($orders)
     <?php


 $count = 1; ?>
     @foreach ($orders as $order)
     <tr>
     
         <td>{{ $count }}</td>
         <td> 
             <p class="text-center ;font-weight: bold;">{{ $order->order_id }}</p>
         </td>
       

         <td>{{ $order->receved_name }}</td>
       
       
         <td>{{ $order->reference_number }}</td>
         <td>
         {{ !empty($order->address) ? $order->address->address : '' }}

         </td>
         <td>
         {{ !empty($order->delegate) ? $order->delegate->name : '' }}

         </td>

         <td>
            <?php $history=\App\Models\OrderHistory::where('order_id',$order->id)->where('status_id',16)->first(); ?>
            @if(isset($history))
            {{$history->status->trans('title')}}
            <br>
            {{$history->updated_at}}
            @endif


         </td>
        <td>
          <?php $history=\App\Models\OrderHistory::where('order_id',$order->id)->where('status_id',$order->user->cost_calc_status_id)->first(); ?>
            @if(isset($history))
            {{$history->status->trans('title')}}
            <br>
            {{$history->updated_at}}
            @endif
           
        </td>

           
     </tr>
     <?php $count++; ?>
     @endforeach
     @endisset

 </tbody>
 <tfoot>
     <tr>
         <th>#</th>
         <th>{{ __('admin_message.Order Number') }}</th>
         <th>
         <label>{{ __('order.received_name') }}</label>
         </th>
         <th>{{ __('admin_message.reference_number') }}</th>
         <th>{{ __('admin_message.branch') }}</th>

         <th>{{ __('admin_message.Delegate') }}</th>

         <th>{{ __('admin_message.received Order') }}</th>
         <th>{{ __('admin_message.Delivered order') }}</th>
     </tr>
 </tfoot>
</table>
@isset($orders)
{!! $orders->appends($_GET)->links() !!}
@endisset

            </div>
        </div>
    </section>
</div>
@endsection

@section('js')



<script>
    $(document).ready(function() {
    $('#order').DataTable({
        retrieve: true,
        fixedColumns: true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
        scrollX: true,
        pageLength: 50,
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                footer: false,
                text: 'Export', // Custom button text
                
            }
        ]

    });

});
</script>
@endsection