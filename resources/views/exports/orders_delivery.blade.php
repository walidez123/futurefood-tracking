 
    <table id="order" class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
 
 <thead>
     <tr>
         <th>#</th>
         <th>{{ __('admin_message.Order Number') }}</th>
         <th>
           <label>{{ __('order.received_name') }}</label>
         </th>
         <th>{{ __('admin_message.reference_number') }}</th>
         <th>{{ __('admin_message.received Order') }}</th>
         <th>{{ __('admin_message.Delivered order') }}</th>
     </tr>
 </thead>
 <tbody>
     <?php

use App\Helpers\OrderHistory;

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

 </tbody>
 <tfoot>
     <tr>
         <th>#</th>
         <th>{{ __('admin_message.Order Number') }}</th>
         <th>
           <label>{{ __('admin_message.receved_name') }}</label>
         </th>
         <th>{{ __('admin_message.reference_number') }}</th>
         <th>{{ __('admin_message.received Order') }}</th>
         <th>{{ __('admin_message.Delivered order') }}</th>
     </tr>
 </tfoot>
</table>
     
     