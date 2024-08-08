 <table id="order"
     class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
     <thead>
         <tr>
             <th><input type="checkbox" id="checkAll"></th>
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
             <th>{{ __('admin_message.Service provider') }}</th>
             <th>{{ __('order.action') }}</th>
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
                 @if ($order->work_type == 1 || $order->work_type == 4)
                     @if (Auth()->user()->company_setting_status != null &&
                             Auth()->user()->company_setting_status->status_shop == $order->status_id)
                         <td><input disabled type="checkbox" name="orders[]" value="{{ $order->id }}" class="ordersId">
                         </td>
                     @else
                         <td><input type="checkbox" name="orders[]" value="{{ $order->id }}" class="ordersId"></td>
                     @endif
                 @else
                     @if (Auth()->user()->company_setting_status != null &&
                             Auth()->user()->company_setting_status->status_res == $order->status_id)
                         <td><input disabled type="checkbox" name="orders[]" value="{{ $order->id }}"
                                 class="ordersId"></td>
                     @else
                         <td><input type="checkbox" name="orders[]" value="{{ $order->id }}" class="ordersId"></td>
                     @endif
                 @endif

                 <td>{{ $count }}</td>
                 <td>
                     <p class="text-center ;font-weight: bold;">{{ $order->order_id }}</p>
                 </td>


                 <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                 <td>
                    @if(!empty($order->address))
                    @if(!empty($order->address->city))
                    {{$order->address->city->trans('title')}}
                    @endif

                    @endif
                </td>
                 <td>{{ $order->receved_name }}</td>
                 <td>{{ $order->receved_phone }} <a href="tel:{{ $order->receved_phone }}" style="padding:5px"><i
                             class="fa fa-phone fa-2x"></i></a>
                     <?php
                     $message = $order->user->company_setting->what_up_message;
                     $message_ar = $order->user->company_setting->what_up_message_ar;
                     
                     $bodytag = str_replace('[order_number]', $order->order_id, $message);
                     $bodytag_ar = str_replace('[order_number]', $order->order_id, $message_ar);
                     $bodytag = str_replace('[store_name]', !empty($order->user) ? $order->user->store_name : '', $bodytag);
                     $bodytag_ar = str_replace('[store_name]', !empty($order->user) ? $order->user->store_name : '', $bodytag_ar); ?>

                     <a href="https://api.whatsapp.com/send?phone={{ $order->receved_phone }}&text={{ urlencode($bodytag_ar) }}"
                         style="padding:5px">
                         <i class="fa-brands fa-whatsapp fa-2x" style="color:green"></i>
                     </a>
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
                 <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }} <br>
                     {{ $order->updated_at }}</td>
                
                 <td>
                    @if(!empty($order->service_provider))
                        {{$order->service_provider->name}} 
                    @else
                        @include('admin.orders.service_provider')
                    @endif
                </td>

                 <td>

                    
                     @if ($order->work_type == 1)
                         @if (in_array('show_order', $permissionsTitle))
                             <a href="{{ route('client-orders.show', $order->id) }}" title="View"
                                 class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                     class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span>
                             </a>
                         @endif
                         @endif

                         @if ($order->work_type == 4)
                             @if (in_array('show_order_fulfillment', $permissionsTitle))
                                 <a href="{{ route('client-orders.show', $order->id) }}" title="View"
                                     class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span
                                         class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span>
                                 </a>
                             @endif
                         @endif


                         <a class="btn btn-sm btn-success" style="margin: 2px;" href="{{url('admin/client-orders/confirmSmb/'.$order->consignmentNo.'')}}"
                         target="_blank">{{__("admin_message.confirmation")}}</a> 
                       

                        



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
             <th>{{ __('admin_message.Service provider') }}</th>
             <th>{{ __('order.action') }}</th>
         </tr>
     </tfoot>
 </table>
