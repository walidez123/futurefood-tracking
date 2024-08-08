<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header"> @lang('admin_message.Main menus') </li>
            <li class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <a href="{{ route('client.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>@lang('app.dashboard')</span>
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs('addresses.index') ? 'active' : '' }}">
                <a href="{{ route('addresses.index') }}">
                    <i class="fa  fa-map-marker"></i> <span>@lang('app.alladdress')</span>
                    </span>
                </a>
            </li>


            <!-- Pickup order for fulfillment & warehouse -->
            @if (auth()->user()->work == 3 || auth()->user()->work == 4)
                <li class="{{ request()->routeIs('orders_pickup.*') ? 'active' : '' }}">
                    <a href="{{ route('orders_pickup.index') }}">
                        <i class="fa  fa-truck"></i> <span>@lang('app.orderspickup', ['attribute' => ''])</span>
                        </span>
                    </a>
                </li>
            @endif




            <!-- end -->


            {{-- @if (auth()->user()->work == 1)
            <li class="{{ request()->routeIs('orderspickup.index') ? 'active' : '' }}">
                <a href="{{route('orderspickup.index')}}">
                    <i class="fa  fa-truck"></i> <span>@lang('app.orderspickup', ['attribute' => ''])</span>
                    </span>
                </a>
            </li>
            @endif --}}
            @if(Auth()->user()->work == 1|| Auth()->user()->work == 2|| Auth()->user()->work == 4)
            <li class="treeview">
                <a href="#">
                    <i class="fa  fa-truck"></i> <span>@lang('app.orders', ['attribute' => ''])</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (Auth()->user()->work == 1)
                        <li {{ request()->routeIs('orders.create', ['work_type' => 1]) ? 'active' : '' }}>
                            <a href="{{ route('orders.create', ['work_type' => 1]) }}">@lang('order.add_new_order')</a>
                        </li>

                        <li>
                            <a href="{{ route('orders.index', ['work_type' => 1]) }}">@lang('order.all_orders')
                                <?php $orderCount = \App\Models\Order::where('work_type', 1)
                                    ->where('user_id', Auth()->user()->id)
                                    ->where('is_returned',0)
                                    ->count(); ?>
                                @if ($orderCount > 0)
                                    <span class="pull-right-container">
                                        <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                    </span>
                                @endif
                            </a>
                        </li>
                    @elseif(auth()->user()->work == 2)
                        <li {{ request()->routeIs('orders.create', ['work_type' => 2]) ? 'active' : '' }}>
                            <a href="{{ route('orders.create', ['work_type' => 2]) }}">@lang('order.add_new_order')</a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index', ['work_type' => 2]) }}">@lang('order.all_orders')
                                <?php $orderCount = \App\Models\Order::where('work_type', 2)
                                    ->where('user_id', Auth()->user()->id)
                                    ->where('is_returned',0)
                                    ->count(); ?>
                                @if ($orderCount > 0)
                                    <span class="pull-right-container">
                                        <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                    </span>
                                @endif
                            </a>
                        </li>
                        <!-- fulfillment -->
                    @elseif(auth()->user()->work == 4)
                        <li {{ request()->routeIs('orders.create', ['work_type' => 4]) ? 'active' : '' }}>
                            <a href="{{ route('orders.create', ['work_type' => 4]) }}">@lang('order.add_new_order')</a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index', ['work_type' => 4]) }}">@lang('order.all_orders')
                                <?php $orderCount = \App\Models\Order::where('work_type', 4)
                                    ->where('user_id', Auth()->user()->id)
                                    ->where('is_returned',0)
                                    ->count(); ?>
                                @if ($orderCount > 0)
                                    <span class="pull-right-container">
                                        <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                    <!-- end fulfillment -->
                    @foreach ($statuses_nav as $status)
                        <li>
                            @if (Auth()->user()->work == 1 && $status->shop_appear == 1)
                                <a href="{{ route('orders.index', str_replace(' ', '_', $status->title)) }}">{{ $status->trans('title') }}
                                    <?php $orderCount = \App\Models\Order::where('work_type', 1)
                                        ->where('user_id', Auth()->user()->id)
                                        ->where('status_id', $status->id)
                                        ->where('is_returned',0)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                                </a>
                            @elseif(Auth()->user()->work == 2 && $status->restaurant_appear == 1)
                                <a href="{{ route('orders.index', str_replace(' ', '_', $status->title)) }}">{{ $status->trans('title') }}
                                    <?php $orderCount = \App\Models\Order::where('work_type', 2)
                                        ->where('user_id', Auth()->user()->id)
                                        ->where('status_id', $status->id)
                                        ->where('is_returned',0)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                                </a>
                                <!-- warehouse -->
                            @elseif(Auth()->user()->work == 3 && $status->storehouse_appear == 1)
                                <!-- <a href="{{ route('orders.index', str_replace(' ', '_', $status->title)) }}">{{ $status->trans('title') }}
                                    <?php $orderCount = \App\Models\Order::where('work_type', 3)
                                        ->where('user_id', Auth()->user()->id)
                                        ->where('status_id', $status->id)
                                        ->where('is_returned',0)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                                </a> -->


                                <!-- warehouse -->
                                <!-- fulfillment -->
                            @elseif(Auth()->user()->work == 4 && $status->fulfillment_appear == 1)
                                <a href="{{ route('orders.index', str_replace(' ', '_', $status->title)) }}">{{ $status->trans('title') }}
                                    <?php $orderCount = \App\Models\Order::where('work_type', 4)
                                        ->where('user_id', Auth()->user()->id)
                                        ->where('status_id', $status->id)
                                        ->where('is_returned',0)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                                </a>
                            @endif
                            <!-- end fulfillment -->
                        </li>
                    @endforeach
                </ul>
            </li>
            @endif
            @if (auth()->user()->work == 1 || auth()->user()->work == 4)

            <li class="{{ request()->routeIs('return_orders.*') ? 'active' : '' }}">
                <a href="{{ route('return_orders.index') }}">
                    <i class="fa fa-exchange" aria-hidden="true"></i> <span>@lang('admin_message.Return requests')</span>
                    </span>
                    <?php $orderCount = \App\Models\Order::where('is_returned', 1)
                                        ->where('user_id', Auth()->user()->id)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                </a>
            </li>
            @endif

            <!--  -->
            @if (auth()->user()->work == 3)
                <li class="{{ request()->routeIs('client-packages.*') ? 'active' : '' }}">
                    <a href="{{ route('client-packages.index') }}">
                        <i class="fa  fa-truck"></i> <span>{{ __('admin_message.Packages') }}</span>
                        </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->work == 4 || auth()->user()->work == 3)
                <li class="{{ request()->routeIs('client-goods.*') ? 'active' : '' }}">
                    <a href="{{ route('client-goods.index') }}">
                        <i class="fa  fa-truck"></i> <span>@lang('goods.Goods', ['attribute' => ''])</span>
                        </span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->work == 4 || auth()->user()->work == 3)
                <li>
                    <a href="{{ route('QR-client.index') }}">
                        <i class="fa fa-sitemap"></i> <span> {{ __('admin_message.Print') }} QR
                            @lang('goods.Goods')</span>


                    </a>
                </li>
                <li class="treeview {{ request()->routeIs('packages_goods*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-brands fa-first-order"></i>
                        <span>{{__('fulfillment.search_stock')}}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('packages_good.product_search')}}">
                            <span> جرد منتج
                                
                                    </span></a>
                        </li>
                        <li><a href="{{route('packages_good.client_Search')}}">
                            <span> جرد منتجات </span></a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->work == 3 || auth()->user()->work == 4)
                <li><a href="{{ route('packages_goods_client.index') }}"><i class="fa-brands fa-first-order"></i>
                        <span> {{ __('admin_message.Packaging goods/cartons') }}</span></a></li>
            @endif
            <li class="{{ request()->routeIs('transactions.client') ? 'active' : '' }}">
                <a href="{{ route('transactions.client') }}">
                    <i class="fa fa-exchange" aria-hidden="true"></i> <span>@lang('app.transactions', ['attribute' => __('app.balance', ['attribute' => ''])])</span>
                    </span>
                </a>
            </li>

            <!-- <li class="{{ request()->routeIs('invoiceClient.index') ? 'active' : '' }}">
                <a href="{{ route('invoiceClient.index') }}">
                    <i class="fa-solid fa-money-bill"></i><span> @lang('order.invoices')</span>
                    </span>
                </a>
            </li>  -->
            {{-- <li class="{{ request()->routeIs('employees') ? 'active' : '' }}">
                <a href="{{ route('employees.index') }}">
                    <i class="fa-solid fa-users"></i> <span> @lang('user.employees') </span>
                    </span>
                </a>
            </li> --}}
            <li class="{{ request()->routeIs('terms.show') ? 'active' : '' }}">
                <a href="{{ route('terms.show') }}">
                    <i class="fa-solid fa-file"></i> <span> @lang('order.terms') </span>
                    </span>
                </a>
            </li>
            {{-- terms.show --}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
