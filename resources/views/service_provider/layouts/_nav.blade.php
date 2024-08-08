<aside class="main-sidebar">
    <section class="sidebar">
        <p>{{ Auth()->user()->name }}</p>
        @php
        $delegates = Auth()->user()->Service_providerDelegate()->get();
        $Arraydelegates = $delegates->pluck('id')->toArray();
        $orders = \App\Models\Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id',
        Auth()->user()->id)->get();
        $shop = Auth()
        ->user()
        ->Service_providerDelegate()
        ->where('work', 1)
        ->get();
        $res = Auth()
        ->user()
        ->Service_providerDelegate()
        ->where('work', 2)
        ->get();
        @endphp
        <ul class="sidebar-menu" data-widget="tree" style="padding-top:10px">
            <li class="active">
                <a href="/{{ Auth()->user()->user_type }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('admin_message.Dashboard') }}</span>
                    </span>
                </a>
            </li>
            <!-- <li class="treeview {{ Request::is('service_provider/service_provider_orders*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span> {{ __('admin_message.orders') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (auth()->user()->work==2 ||auth()->user()->work==3)
                        <li>
                            <a href="{{ route('service_provider_orders.shipToday', 2) }}">
                                <i class="fa fa-truck"></i>
                                <span>{{ __("admin_message.Today's Orders for Restaurants") }}</span>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->work==1 ||auth()->user()->work==3)
                        <li>
                            <a href="{{ route('service_provider_orders.shipToday', 1) }}">
                                <i class="fa fa-truck"></i>
                                <span>{{ __("admin_message.Today's Orders for Customers") }}</span>
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li> -->
            @if(in_array(1, auth()->user()->user_works->pluck('work')->toArray()))

            <li class="treeview {{ Request::is('service_provider/service_provider_orders*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span> {{ __('admin_message.Customer Orders') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>

                        <a href="{{route('service_provider_orders.index', ['work_type' => 1])}}">
                            <span>@lang('order.all_orders') </span>
                            <?php $orderCount = $orders->where('work_type',1)->count(); ?>
                            @if ($orderCount > 0)
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                            </span>
                            @endif
                        </a>
                    </li>
                    @foreach($statuses_nav as $status)
                    @if ($status->shop_appear==1)
                    <li>
                        <a href="{{ route('service_provider_orders.index',['work_type'=>1,'status'=>$status->id]) }}">
                            <span>{{$status->trans('title')}}</span>
                            <?php $orderCount = $orders->where('work_type',1)->where('status_id',$status->id)->count(); ?>
                            @if ($orderCount > 0)
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                            </span>
                            @endif
                        </a>
                    </li>
                    @endif
                    @endforeach

                </ul>
            </li>
            @endif
            @if(in_array(2, auth()->user()->user_works->pluck('work')->toArray()))


            <li class="treeview {{ Request::is('service_provider/service_provider_orders*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span> {{ __('admin_message.Customer restaurant') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>

                </a>
                <ul class="treeview-menu">
                    <li>

                        <a href="{{route('service_provider_orders.index', ['work_type' => 2])}}">
                            <span>@lang('order.all_orders') </span>
                            <?php $orderCount = $orders->where('work_type',2)->count(); ?>
                            @if ($orderCount > 0)
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                            </span>
                            @endif
                        </a>
                    </li>
                    @foreach($statuses_nav as $status)

                    @if ($status->restaurant_appear==1)
                    <li>
                        <a href="{{ route('service_provider_orders.index',['work_type'=>2,'status'=>$status->id]) }}">
                            <span>{{$status->trans('title')}}</span>
                            </span>
                            <?php $orderCount = $orders->where('work_type',2)->where('status_id',$status->id)->count(); ?>
                            @if ($orderCount > 0)
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                            </span>
                            @endif
                        </a>

                    </li>
                    @endif
                    @endforeach

                </ul>
            </li>
            @endif
            <!-- Falfument  -->

            @if(in_array(4, auth()->user()->user_works->pluck('work')->toArray()))


<li class="treeview {{ Request::is('service_provider/service_provider_orders*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-truck"></i>
        <span> {{ __('fulfillment.fulfillment orders') }}</span>
        <span class="pull-right-container">
            <i class="fa-solid fa-angle-left"></i>
        </span>

    </a>
    <ul class="treeview-menu">
        <li>

            <a href="{{route('service_provider_orders.index', ['work_type' => 4])}}">
                <span>@lang('order.all_orders') </span>
                <?php $orderCount = $orders->where('work_type',4)->count(); ?>
                @if ($orderCount > 0)
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                </span>
                @endif
            </a>
        </li>
        @foreach($statuses_nav as $status)

        @if ($status->fulfillment_appear==1)
        <li>
            <a href="{{ route('service_provider_orders.index',['work_type'=>4,'status'=>$status->id]) }}">
                <span>{{$status->trans('title')}}</span>
                </span>
                <?php $orderCount = $orders->where('work_type',4)->where('status_id',$status->id)->count(); ?>
                @if ($orderCount > 0)
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                </span>
                @endif
            </a>

        </li>
        @endif
        @endforeach

    </ul>
</li>
@endif













            <!--  -->
            <li class="treeview {{ Request::is('service_provider/s_p_delegates*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span> {{ __('admin_message.Delegates') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array(1, auth()->user()->user_works->pluck('work')->toArray()))

                    <li> <a href="{{ route('s_p_delegates.index', ['type' => 1]) }}">
                            <span>
                                {{ __('admin_message.Customer Representatives') }}</span>
                            </span> </a></li>
                    @endif
                    @if(in_array(2, auth()->user()->user_works->pluck('work')->toArray()))

                    <li>
                        <a href="{{ route('s_p_delegates.index', ['type' => 2]) }}">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>{{ __('admin_message.Restaurant Representatives') }}</span>
                            </span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('s_p_vehicles.index') }}">
                            <i class="fa fa-car"></i> <span>{{ __('admin_message.vehicles') }}</span>


                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('service_provider/service_provider_DayReport*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-money-bill"></i>
                    <span> {{ __('admin_message.Financial') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('transactions.service_provider') }}">
                            <i class="fa fa-money-bill"></i>
                            <span>@lang('app.Company financial accounts')</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transactions.service_provider_delegate') }}">
                            <i class="fa fa-money-bill"></i>
                            <span>@lang('app.Delegate financial accounts')</span>
                            </span>
                        </a>
                    </li>


                </ul>
            </li>
            @if (Auth()->user()->show_report == 1)
            <li class="">
                <a href="{{ route('service_provider_DayReport.index') }}">
                    <i class="fa fa-file" aria-hidden="true"></i><span>{{ __('admin_message.External Reports') }}</span>
                    </span>
                </a>
            </li>
            @endif
            <li class="treeview {{ Request::is('service_provider/order_rule_provider*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-money-bill"></i>
                    <span> {{ __('admin_message.Rules for Appointing Delegates') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('order_rule_provider.index') }}">
                            {{ __('admin_message.Rules for Appointing Delegates') }} </a></li>
                    <li><a href="{{ route('order_rule_provider.create') }}">{{ __('admin_message.Add') }}
                        </a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>