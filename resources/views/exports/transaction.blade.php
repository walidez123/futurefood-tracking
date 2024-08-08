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

        </tr>
        <?php $count++ ?>
        @endforeach
    </tbody>
</table>
<table>
    @if($cod=='cod')
    <tr>
        <th>{{ trans('admin_message.all_debtor') }}</th>
        <td>{{$count_debtor ? $count_debtor : '0'}}</td>
    </tr>

    @else
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
    @endif
</table>
<!--  -->
@if(count($pallet_subscriptions)>0)
<table id="example2" class="data_table  datatable table table-bordered table-striped tab-pane" >
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
        <?php $count2 = 1; ?>
        @foreach ($pallet_subscriptions as $transaction)
        <tr>
            <td>{{ $count2 }}</td>
            <td>

                {{ $transaction->transactionType->trans('description') }}
            </td>
            <td>{{ $transaction->cost }}</td>
            <td>{{ $transaction->clientPackagesGoods->package->title }}</td>
            <th>{{ $transaction->start_date }}</th>
            <th>
                @if($transaction->type=='daily')
                {{__('admin_message.daily')}}
                @else
                {{__('admin_message.Monthly')}}


                @endif
            </th>

        </tr>
        <?php $count2++; ?>
        @endforeach
    </tbody>
</table>
@endif


<!--  -->