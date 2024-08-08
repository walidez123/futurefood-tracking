 
    <table id="order" class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
 
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('admin_message.Order Number') }}</th>
            <th>
              <label>{{ __('order.sender_name') }}</label>
            </th>
            <th>{{ __('order.delivery_city') }}  </th>
            <th>{{ __('order.received_name') }}</th>
            <th>{{ __('order.received_phone') }}</th>
            <th>{{ __('order.amount') }}</th>
            <th>{{ __('order.ship_to') }}</th>
            <th>{{ __('admin_message.number') }}</th>
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
                <p class="text-center ;font-weight: bold;">{{ $order->order_id }}</p>
            </td>
          

            <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
            <td>{{ !empty($order->senderCity) ? $order->senderCity->trans('title') : '' }}</td>
            <td>{{ $order->receved_name }}</td>
            <td>{{$order->receved_phone}} <a href="tel:{{$order->receved_phone}}" style="padding:5px"><i class="fa fa-phone fa-2x"></i></a> 
            </td>
            <td>{{ $order->amount }}</td>
            <td>{{ !empty($order->recevedCity) ? $order->recevedCity->trans('title') : '' }}
            </td>
            <td>{{ $order->number_count }}</td>
            <td>{{ $order->reference_number }}</td>

            <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }} <br>
                {{ $order->updated_at }}</td>

            <td>
                {{ !empty($order->delegate) ? $order->delegate->name : '' }}
                
            </td>
            <td>{{ !empty($order->service_provider) ? $order->service_provider->name : '' }}</td>      
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
            <th>{{ __('order.delivery_city') }}  </th>
            <th>{{ __('order.received_name') }}</th>
            <th>{{ __('order.received_phone') }}</th>
            <th>{{ __('order.amount') }}</th>
            <th>{{ __('order.ship_to') }}</th>
            <th>{{ __('admin_message.number') }}</th>
            <th>{{ __('admin_message.reference_number') }}</th>
            <th>{{ __('admin_message.status') }}</th>
            <th>{{ __('admin_message.Delegate') }}</th>
            <th>{{ __('admin_message.Service provider') }}</th>
        </tr>
    </tfoot>
</table>
        
        