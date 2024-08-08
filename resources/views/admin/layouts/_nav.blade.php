<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" style="padding-top:10px">
            <li class="header strong">{{ __('admin_message.Main menus') }}</li>
            <li>
                <a href="/{{ Auth()->user()->user_type }}">
                    <i class="fa-solid fa-house"></i> <span>{{ __('admin_message.Dashboard') }}</span>
                    </span>
                </a>
            </li>
            @if (in_array('show_order', $permissionsTitle) && (in_array(4, $user_type) || in_array(1, $user_type)))

                <li class="treeview  {{ request()->routeIs('run_sheet.*') ? 'active' : '' }} ">
                    <a href="#">
                        <i class="fa-solid fa-paperclip"></i> <span> {{ __('admin_message.run sheet') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <!-- Run sheet  -->
                        @if (in_array(1, $user_type))

                            @if (in_array('show_order', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/run_sheet?work_type=1' ? 'active' : '' }}">
                                    <a href="{{ route('run_sheet.index', ['work_type' => 1]) }}">@lang('admin_message.run sheet')
                                        {{ __('admin_message.Clients') }}</a>
                                </li>
                            @endif
                        @endif

                        <!-- Run sheet  -->
                        @if (in_array(4, $user_type))
                            @if (in_array('show_order', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/run_sheet?work_type=4' ? 'active' : '' }}">
                                    <a href="{{ route('run_sheet.index', ['work_type' => 4]) }}">@lang('admin_message.run sheet')
                                        {{ __('fulfillment.fulfillment_clients') }}</a>
                                </li>
                            @endif
                        @endif

                    </ul>



                    <!--  -->
                </li>
            @endif
            @if (in_array(1, $user_type))
                @if (in_array('show_order', $permissionsTitle) || in_array('add_order', $permissionsTitle))


                    <li
                        class="treeview {{ Str::is('/admin/client-orders?work_type=1*', request()->getRequestUri()) ? 'active' : '' }}  {{ Str::is('/admin/client-orders/create?work_type=1', request()->getRequestUri()) ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span>
                                {{ __('admin_message.Customer requests sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('add_order', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/client-orders/create?work_type=1' ? 'active' : '' }}">
                                    <a
                                        href="{{ route('client-orders.create', ['work_type' => 1]) }}">@lang('order.add_new_order')</a>
                                </li>
                            @endif
                            @if (in_array('add_order', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/client-orders/import?work_type=1' ? 'active' : '' }}">
                                    <a
                                        href="{{ route('client-orders.import', ['work_type' => 1]) }}">@lang('order.import_order')</a>
                                </li>
                            @endif

                            @if (in_array('show_order', $permissionsTitle))

                                <li
                                    class="{{ request()->getRequestUri() == '/admin/client-orders?work_type=1' ? 'active' : '' }}">
                                    <a href="{{ route('client-orders.index', ['work_type' => 1]) }}">@lang('order.all_orders')
                                        <?php $orderCount = \App\Models\Order::where('work_type', 1)
                                            ->where('company_id', Auth()->user()->company_id)
                                            ->where('is_returned',0)->count(); ?>
                                        @if ($orderCount > 0)
                                            <span class="pull-right-container">
                                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                            </span>
                                        @endif
                                    </a>

                                </li>
                            @endif

                            @if (in_array('show_order', $permissionsTitle))


                                @foreach ($statuses_nav as $status)
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/client-orders?work_type=1&status=' . $status->id . '' ? 'active' : '' }}">
                                        @if (in_array(1, $user_type) && $status->shop_appear == 1)
                                            <a
                                                href="{{ route('client-orders.index', ['work_type' => 1, 'status' => $status->id]) }}">{{ $status->trans('title') }}

                                                <?php $orderCount = \App\Models\Order::where('work_type', 1)
                                                    ->where('company_id', Auth()->user()->company_id)
                                                    ->where('status_id', $status->id)
                                                    ->where('is_returned',0)
                                                    ->count(); ?>
                                                @if ($orderCount > 0)
                                                    <span class="pull-right-container">
                                                        <small
                                                            class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                    </span>
                                                @endif
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if (in_array(2, $user_type))
                @if (in_array('show_order_res', $permissionsTitle) || in_array('add_order_res', $permissionsTitle))


                    <li
                        class="treeview {{ Str::is('/admin/client-orders?work_type=2*', request()->getRequestUri()) ? 'active' : '' }}  {{ Str::is('/admin/client-orders/create?work_type=2', request()->getRequestUri()) ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span>
                                {{ __('admin_message.Customer restaurant sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('add_order_res', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/client-orders/create?work_type=2' ? 'active' : '' }}">
                                    <a
                                        href="{{ route('client-orders.create', ['work_type' => 2]) }}">@lang('order.add_new_order')</a>
                                </li>
                            @endif

                            @if (in_array('show_order_res', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/client-orders?work_type=2' ? 'active' : '' }}">
                                    <a href="{{ route('client-orders.index', ['work_type' => 2]) }}">@lang('order.all_orders')
                                        <?php $orderCount = \App\Models\Order::where('work_type', 2)
                                            ->where('company_id', Auth()->user()->company_id)                                                    
                                            ->where('is_returned',0)
                                            ->count(); ?>
                                        @if ($orderCount > 0)
                                            <span class="pull-right-container">
                                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                            </span>
                                        @endif
                                    </a>
                                    </a>
                                </li>
                            @endif

                            @if (in_array('show_order_res', $permissionsTitle))
                                @foreach ($statuses_nav as $status)
                                    @if (in_array(2, $user_type) && $status->restaurant_appear == 1)
                                        <li
                                            class="{{ request()->getRequestUri() == '/admin/client-orders?work_type=2&status=' . $status->id . '' ? 'active' : '' }}">

                                            <a
                                                href="{{ route('client-orders.index', ['work_type' => 2, 'status' => $status->id]) }}">{{ $status->trans('title') }}
                                                <?php $orderCount = \App\Models\Order::where('work_type', 2)
                                                    ->where('company_id', Auth()->user()->company_id)
                                                    ->where('status_id', $status->id)
                                                    ->where('is_returned',0)
                                                    ->count(); ?>
                                                @if ($orderCount > 0)
                                                    <span class="pull-right-container">
                                                        <small
                                                            class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif


                        </ul>
                    </li>
                @endif
            @endif

            @if (in_array(3, $user_type))
                @if (in_array('show_order_warehouse', $permissionsTitle) || in_array('add_order_warehouse', $permissionsTitle))


                    <li class="treeview ">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span>
                                {{ __('admin_message.Warehouse sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('add_order_warehouse', $permissionsTitle))
                                <li
                                    {{ request()->routeIs('client-orders.create', ['work_type' => 3]) ? 'active' : '' }}>
                                    <a
                                        href="{{ route('client-orders.create', ['work_type' => 3]) }}">@lang('order.add_new_order')</a>
                                </li>
                            @endif




                            <!--  -->
                            @if (in_array('show_order_warehouse', $permissionsTitle))
                                <li
                                    {{ request()->routeIs('client-orders.index', ['work_type' => 3]) ? 'active' : '' }}>
                                    <a href="{{ route('client-orders.index', ['work_type' => 3]) }}">@lang('order.all_orders')
                                        <?php $orderCount = \App\Models\Order::where('work_type', 3)
                                            ->where('company_id', Auth()->user()->company_id)
                                           ->where('is_returned',0)->count(); ?>
                                        @if ($orderCount > 0)
                                            <span class="pull-right-container">
                                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                            </span>
                                        @endif
                                    </a>
                                    </a>
                                </li>
                            @endif

                            @if (in_array('show_order_warehouse', $permissionsTitle))
                                @foreach ($statuses_nav as $status)
                                    @if (in_array(3, $user_type) && $status->storehouse_appear == 1)
                                        <li>
                                            <a
                                                href="{{ route('client-orders.index', ['work_type' => 3, 'status' => $status->id]) }}">{{ $status->trans('title') }}
                                                <?php $orderCount = \App\Models\Order::where('work_type', 3)
                                                    ->where('company_id', Auth()->user()->company_id)
                                                    ->where('status_id', $status->id)
                                                    ->where('is_returned',0)
                                                    ->count(); ?>
                                                @if ($orderCount > 0)
                                                    <span class="pull-right-container">
                                                        <small
                                                            class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif


                        </ul>
                    </li>
                @endif
            @endif

            @if (in_array(4, $user_type))
                @if (in_array('show_order_fulfillment', $permissionsTitle) || in_array('add_order_fulfillment', $permissionsTitle))


                    <li
                        class="treeview {{ Str::is('/admin/client-orders?work_type=4*', request()->getRequestUri()) ? 'active' : '' }}  {{ Str::is('/admin/client-orders/create?work_type=4', request()->getRequestUri()) ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span>
                                {{ __('fulfillment.fulfillment sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('add_order_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ Str::is('/admin/client-orders/create?work_type=4', request()->getRequestUri()) ? 'active' : '' }}">
                                    <a
                                        href="{{ route('client-orders.create', ['work_type' => 4]) }}">@lang('order.add_new_order')</a>
                                </li>
                            @endif




                            @if (in_array('show_order_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ Str::is('/admin/client-orders?work_type=4', request()->getRequestUri()) ? 'active' : '' }}">
                                    <a href="{{ route('client-orders.index', ['work_type' => 4]) }}">@lang('order.all_orders')
                                        <?php $orderCount = \App\Models\Order::where('work_type', 4)
                                            ->where('company_id', Auth()->user()->company_id)
                                            ->where('is_returned',0)
                                            ->count(); ?>
                                        @if ($orderCount > 0)
                                            <span class="pull-right-container">
                                                <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                            </span>
                                        @endif
                                    </a>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('show_order_fulfillment', $permissionsTitle))
                                @foreach ($statuses_nav as $status)
                                    @if (in_array(4, $user_type) && $status->fulfillment_appear == 1)
                                        <li
                                            class="{{ request()->getRequestUri() == '/admin/client-orders?work_type=4&status=' . $status->id . '' ? 'active' : '' }}">
                                            <a
                                                href="{{ route('client-orders.index', ['work_type' => 4, 'status' => $status->id]) }}">{{ $status->trans('title') }}
                                                <?php $orderCount = \App\Models\Order::where('work_type', 4)
                                                    ->where('company_id', Auth()->user()->company_id)
                                                    ->where('status_id', $status->id)
                                                    ->where('is_returned',0)
                                                    ->count(); ?>
                                                @if ($orderCount > 0)
                                                    <span class="pull-right-container">
                                                        <small
                                                            class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif


                        </ul>
                    </li>
                @endif
            @endif
              {{-- اسكان اوردر --}}
              @if (in_array('scan_order_last_mile', $permissionsTitle) ||
                    in_array('scan_order_restaurant', $permissionsTitle) ||
                    in_array('scan_order_warehouse', $permissionsTitle) ||
                    in_array('scan_order_Fulfilmant', $permissionsTitle))

                <li class="treeview  {{ request()->routeIs('scan-orders*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-solid fa-cart-plus"></i> <span> {{ __('admin_message.Scan orders') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(1, $user_type) && in_array('scan_order_last_mile', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/order-scan?work_type=1' ? 'active' : '' }}">
                                <a
                                    href="{{ route('scan-orders.index', ['work_type' => 1]) }}">{{ __('admin_message.Customer Orders') }}</a>
                            </li>
                        @endif
                        <!-- @if (in_array(2, $user_type) && in_array('scan_order_restaurant', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/order-scan?work_type=2' ? 'active' : '' }}">
                                <a
                                    href="{{ route('scan-orders.index', ['work_type' => 2]) }}">{{ __('admin_message.Customer restaurant') }}</a>
                            </li>
                        @endif -->
                        <!-- @if (in_array(3, $user_type) && in_array('scan_order_warehouse', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/order-scan?work_type=3' ? 'active' : '' }}">
                                <a
                                    href="{{ route('scan-orders.index', ['work_type' => 3]) }}">{{ __('admin_message.warehouse orders') }}</a>
                            </li>
                        @endif -->
                        @if (in_array(4, $user_type) && in_array('scan_order_Fulfilmant', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/order-scan?work_type=4' ? 'active' : '' }}">
                                <a
                                    href="{{ route('scan-orders.index', ['work_type' => 4]) }}">{{ __('admin_message.Fulfilmant orders') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('show_order', $permissionsTitle))
                <li class="treeview ">

                    <a href="#">
                        <i class="fa-solid fa-search"></i> <span>
                            {{ __('admin_message.filter_and_search') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                
                    <ul class="treeview-menu">
                        @if (in_array(1, $user_type))
                            <li {{ request()->routeIs('filter-and-search*') ? 'active' : '' }}>
                                <a
                                    href="{{ route('filter-and-search.index', ['work_type' => 1]) }}">{{ __('admin_message.Customer Orders') }}</a>
                            </li>
                        @endif
                        @if (in_array(2, $user_type) )
                            <li {{ request()->routeIs('filter-and-search') ? 'active' : '' }}>
                                <a
                                    href="{{ route('filter-and-search.index', ['work_type' => 2]) }}">{{ __('admin_message.Customer restaurant') }}</a>
                            </li>
                        @endif
                        {{-- @if (in_array(3, $user_type) )
                            <li {{ request()->routeIs('filter-and-search') ? 'active' : '' }}>
                                <a
                                    href="{{ route('filter-and-search.index', ['work_type' => 3]) }}">{{ __('admin_message.warehouse orders') }}</a>
                            </li>
                        @endif --}}
                        @if (in_array(4, $user_type))
                            <li {{ request()->routeIs('filter-and-search') ? 'active' : '' }}>
                                <a
                                    href="{{ route('filter-and-search.index', ['work_type' => 4]) }}">{{ __('admin_message.Fulfilmant orders') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>

            @endif

            <?php $active=\App\Models\CompanyServiceProvider::where('company_id',Auth()->user()->company_id)->where('service_provider_id',908)->where('is_active',1)->first();  ?>
            @if ($active!=null)
            <li {{ request()->routeIs('confirmed-smb') ? 'active' : '' }}>
                                
            <a href="{{ route('confirmed-smb.index') }}"> <i class="fa fa-sitemap"></i> <span> {{ __('admin_message.Unconfirmed smb requests') }}</>
            </li>
                     
                    
            @endif 

            <!--  -->
            @if (in_array(1, $user_type) || in_array(3, $user_type) || in_array(4, $user_type))
                @if (in_array('show_pickup_order', $permissionsTitle) || in_array('show_pickup_order_warehouse', $permissionsTitle) || in_array('show_pickup_order_fulfillment', $permissionsTitle))

                    <li
                        class="treeview {{ request()->routeIs('pickup-orders*') ? 'active' : '' }}  {{ request()->routeIs('client_orders_pickup*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span>
                                {{ __('admin_message.Pickup requests for warehouse') }}
                            </span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                            <?php $pickupOrderCount = \App\Models\Order::where('company_id', Auth()->user()->company_id)
                                ->where('status_id', Auth()->user()->company_setting->status_pickup)
                                ->count();
                            $pickupOrderfulfillmentCount = \App\Models\Pickup_order::where('work_type', 4)
                                ->where('company_id', Auth()->user()->company_id)
                                ->whereDoesntHave('client_packages_good')->count();
                                $pickupOrderwarehouseCount = \App\Models\Pickup_order::where('work_type', 3)
                                ->where('company_id', Auth()->user()->company_id)->whereDoesntHave('client_packages_good')
                                ->count();
                            ?>
                            @if ($pickupOrderCount > 0 || $pickupOrderfulfillmentCount > 0 || $pickupOrderwarehouseCount>0)
                                <span class="pull-right-container">
                                    <small
                                        class="label pull-right bg-yellow bgs-yellow ">{{ $pickupOrderCount + $pickupOrderfulfillmentCount + $pickupOrderwarehouseCount }}
                                    </small>
                                </span>
                            @endif
                        </a>
                        <ul class="treeview-menu">
                        @if (in_array(1, $user_type) )
                           @if (in_array('show_pickup_order', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/pickup-orders?work_type=1' ? 'active' : '' }}">

                                <a href="{{ route('pickup-orders.index', ['work_type' => 1]) }}">
                                    <span>{{ __('admin_message.Pickup requests client') }}</span>
                                    <?php $orderCount = \App\Models\Order::where('work_type', 1)
                                        ->where('company_id', Auth()->user()->company_id)
                                        ->where('status_id', Auth()->user()->company_setting->status_pickup)
                                        ->count(); ?>
                                    @if ($orderCount > 0)
                                        <span class="pull-right-container">
                                            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                        </span>
                                    @endif
                                </a>
                            </li>
                            @endif
                            @endif
                            @if (in_array(3, $user_type))
                                @if (in_array('show_pickup_order_warehouse', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/client_orders_pickup?work_type=3' ? 'active' : '' }}">

                                        <a href="{{ route('client_orders_pickup.index', ['work_type' => 3]) }}">
                                            <span>{{ __('admin_message.Pickup requests warehouse') }}</span>
                                            
                                            @if ($pickupOrderwarehouseCount > 0)
                                                <span class="pull-right-container">
                                                    <small
                                                        class="label pull-right bg-yellow">{{ $pickupOrderwarehouseCount }}</small>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if (in_array(4, $user_type))
                                @if (in_array('show_pickup_order_fulfillment', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/client_orders_pickup?work_type=4' ? 'active' : '' }}">
                                        <a href="{{ route('client_orders_pickup.index', ['work_type' => 4]) }}">
                                            <span>{{ __('admin_message.Pickup requests fulfillment') }}</span>
                                         
                                            @if ($pickupOrderfulfillmentCount > 0)
                                                <span class="pull-right-container">
                                                    <small
                                                        class="label pull-right bg-yellow">{{ $pickupOrderfulfillmentCount }}</small>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if (in_array(1, $user_type) || in_array(2, $user_type)|| in_array(4,$user_type))

                @if (in_array('show_return_order', $permissionsTitle) || in_array('show_return_order_res', $permissionsTitle) || in_array('show_return_order_ful', $permissionsTitle) )

                    <li class="treeview {{ request()->routeIs('return-orders*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-cart-plus"></i> <span> {{ __('admin_message.Return requests') }}
                            </span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array(1, $user_type))

                                @if (in_array('show_return_order', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/return-orders?work_type=1' ? 'active' : '' }}">
                                        <a href="{{ route('return-orders.index', ['work_type' => 1]) }}">
                                            <span>{{ __('admin_message.Return requests client') }}</span>
                                            <?php $orderCount = \App\Models\Order::NotDelegated()
                                                ->where('is_returned', 1)
                                                ->where('company_id', Auth()->user()->company_id)
                                                ->count(); ?>
                                            @if ($orderCount > 0)
                                                <span class="pull-right-container">
                                                    <small
                                                        class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                </span>
                                            @endif
                                        </a>
                                    </li>


                                @endif
                            @endif
                            @if (in_array(2, $user_type))

                                @if (in_array('show_return_order_res', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/return-orders?work_type=2' ? 'active' : '' }}">

                                        <a href="{{ route('return-orders.index', ['work_type' => 2]) }}">
                                            <span>{{ __('admin_message.Return requests restaurant') }}</span>
                                            <?php $orderCount = \App\Models\Order::NotDelegatedRes()
                                                ->where('is_returned', 1)
                                                ->where('company_id', Auth()->user()->company_id)
                                                ->count(); ?>
                                            @if ($orderCount > 0)
                                                <span class="pull-right-container">
                                                    <small
                                                        class="label pull-right bg-yellow">{{ $orderCount }}</small>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif
                            @if (in_array(4, $user_type))

@if (in_array('show_return_order_ful', $permissionsTitle))
<li>
    <a href="{{ route('return-orders.index', ['work_type' => 4]) }}">
<span>{{ __('admin_message.Return requests fulfillment') }}</span>
<?php $orderCount = \App\Models\Order::NotDelegatedFul()
                                                ->where('is_returned', 1)
                                                ->where('company_id', Auth()->user()->company_id)
                                                ->count(); ?>
@if ($orderCount > 0)
<span class="pull-right-container">
    <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
</span>
@endif
</a>
</li>
@endif
@endif 

                            
                        </ul>
                    </li>
                @endif
            @endif
            @if (in_array('show_client', $permissionsTitle) ||
                    in_array('show_resturant', $permissionsTitle) ||
                    in_array('show_client_warehouse', $permissionsTitle) ||
                    in_array('show_client_fulfillment', $permissionsTitle))
                <!-- client -->
                <li class="treeview {{ request()->routeIs('clients*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-solid fa-users"></i> <span>{{ __('admin_message.Customers service') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(1, $user_type))
                            @if (in_array('show_client', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients?type=1' ? 'active' : '' }}">

                                    <a href="{{ route('clients.index', ['type' => 1]) }}">
                                        {{ __('admin_message.Clients') }}</a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type))
                            @if (in_array('show_resturant', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients?type=2' ? 'active' : '' }}">
                                    <a href="{{ route('clients.index', ['type' => 2]) }}">
                                        {{ __('admin_message.restaurants') }}</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array(3, $user_type))
                            @if (in_array('show_client_warehouse', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients?type=3' ? 'active' : '' }}">

                                    <a href="{{ route('clients.index', ['type' => 3]) }}">
                                        {{ __('admin_message.Warehouse Clients') }}</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array(4, $user_type))
                            @if (in_array('show_client_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients?type=4' ? 'active' : '' }}">

                                    <a href="{{ route('clients.index', ['type' => 4]) }}">
                                        {{ __('fulfillment.fulfillment_clients') }}</a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(1, $user_type))

                            @if (in_array('show_api_client', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients/api?type=1' ? 'active' : '' }}">
                                    <a href="{{ route('clients.api', ['type' => 1]) }}">
                                        <span> api {{ __('admin_message.Client') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(4, $user_type))

                            @if (in_array('show_api_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients/api?type=4' ? 'active' : '' }}">

                                    <a href="{{ route('clients.api', ['type' => 4]) }}">
                                        <span> api {{ __('fulfillment.fulfillment') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type))

                            @if (in_array('add_resturant', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/clients/api?type=2' ? 'active' : '' }}">

                                    <a href="{{ route('clients.api', ['type' => 2]) }}">
                                        <span> api {{ __('admin_message.restaurants') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>
            @endif
          

<!-- 
            @if (in_array('show_rate', $permissionsTitle))
                <li class="{{ request()->routeIs('rate_orders*') ? 'active' : '' }}">
                    <a href="{{ route('rate_orders.index') }}">
                        <i class="fa-regular fa-star"></i> <sph,an>
                            {{ __('admin_message.Customer evaluation') }}</span>
                    </a>
                </li>
            @endif -->

            @if (
                (in_array(2, $user_type) || in_array(1, $user_type) || in_array(4, $user_type)) &&
                    (in_array('add_delegate', $permissionsTitle) || in_array('show_delegate', $permissionsTitle)))

                <li
                    class="treeview {{ request()->routeIs('delegates*') ? 'active' : '' }} {{ request()->routeIs('vehicles*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-regular fa-circle-user"></i> <span>{{ __('admin_message.Delegates') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(2, $user_type) || in_array(1, $user_type) || in_array(4, $user_type))
                            @if (in_array('add_delegate', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/delegates/create' ? 'active' : '' }}">

                                    <a href="{{ route('delegates.create') }}">
                                        {{ __('admin_message.Create Delegate') }}</span>
                                        </span> </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type) || in_array(1, $user_type) || in_array(4, $user_type))
                            @if (in_array('add_delegate', $permissionsTitle))
                                <li class="{{ request()->getRequestUri() == '/admin/delegates' ? 'active' : '' }}">

                                    <a href="{{ route('delegates.index') }}">
                                        {{ __('admin_message.Watch the delegates') }}</span>
                                        </span> </a>
                                </li>
                            @endif
                        @endif




                        <!--  -->
                        @if (in_array('show_follow', $permissionsTitle))
                            <li
                                class="{{ request()->getRequestUri() == '/admin/delegates/tracking' ? 'active' : '' }}">
                                <a href="{{ route('delegates.tracking') }}">
                                    <span>{{ __('admin_message.Tracking representatives') }}</span>
                                </a>
                            </li>
                        @endif
                        @if (in_array('show_Vehicle', $permissionsTitle))
                            <li class="{{ request()->routeIs('vehicles*') ? 'active' : '' }}">

                                <a href="{{ route('vehicles.index') }}">
                                    <i class="fa fa-car"></i> <span>{{ __('admin_message.vehicles') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (in_array('show_balances', $permissionsTitle) ||
                    in_array('show_balance_fulfillment', $permissionsTitle) ||
                    in_array('show_balance_warehouse', $permissionsTitle) ||
                    in_array('show_balance_res', $permissionsTitle) ||
                    in_array('show_balance_service_provider', $permissionsTitle) ||
                    in_array('show_balance_delegate', $permissionsTitle) ||
                    in_array('show_invoice', $permissionsTitle))
                <li
                    class="treeview {{ request()->routeIs('report.*') ? 'active' : '' }} {{ request()->routeIs('client.balances*') ? 'active' : '' }}  {{ request()->routeIs('delegate.balances*') ? 'active' : '' }} {{ request()->routeIs('service_provideradmin.balances*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>{{ __('admin_message.Accounting') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(1, $user_type))

                            @if (in_array('show_balances', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/balances?type=1' ? 'active' : '' }}">

                                    <a href="{{ route('client.balances', ['type' => 1]) }}">
                                        <span>{{ __('admin_message.Wallet Clients') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if (in_array(4, $user_type))

                            @if (in_array('show_balance_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/balances?type=4' ? 'active' : '' }}">

                                    <a href="{{ route('client.balances', ['type' => 4]) }}">
                                        <span>{{ __('admin_message.Wallet fulfillment') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if (in_array(3, $user_type))
                            @if (in_array('show_balance_warehouse', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/balances?type=3' ? 'active' : '' }}">

                                    <a href="{{ route('client.balances', ['type' => 3]) }}">
                                        <span>{{ __('admin_message.Wallet Warehouse Clients') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif



                        @if (in_array(2, $user_type))

                            @if (in_array('show_balance_res', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/balances?type=2' ? 'active' : '' }}">

                                    <a href="{{ route('client.balances', ['type' => 2]) }}">
                                        <span>{{ __('admin_message.Wallet Restaurants') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type) || in_array(1, $user_type))
                            @if (in_array('show_balance_service_provider', $permissionsTitle))
                                <li
                                    class="{{ request()->routeIs('service_provideradmin.balances*') ? 'active' : '' }}">
                                    <a href="{{ route('service_provideradmin.balances') }}">
                                        <span> {{ __('admin_message.Wallet service providers') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif


                        @if (in_array(1, $user_type) || in_array(2, $user_type) || in_array(4, $user_type))
                            @if (in_array('show_balance_delegate', $permissionsTitle))
                                <li class="{{ request()->routeIs('delegate.balances*') ? 'active' : '' }}">
                                    <a href="{{ route('delegate.balances') }}">
                                        <span>{{ __('admin_message.Wallet Delegates') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif



                        @if (in_array('show_invoice', $permissionsTitle))
                            <li class="{{ request()->routeIs('report.*') ? 'active' : '' }}">

                                <a href="{{ route('report.index') }}">
                                    <span>{{ __('admin_message.Invoices') }}</span>
                                    </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <!-- المحاسبه -->
            {{-- @if (in_array(1, $user_type))
                @if (in_array('show_order', $permissionsTitle))
                <li>
                    <a href="{{ route('client-orders.index') }}/?notDelegated1">
        <i class="fa fa-sitemap"></i> <span
            style="display:flex;width: 16.5rem;overflow: hidden;white-space: normal;word-wrap: break-word;">{{ __('admin_message.Transferring requests from customer') }}</span>
        <?php $orderCount = \App\Models\Order::NotDelegated()
            ->where('is_returned', 0)
            ->where('company_id', Auth()->user()->company_id)
            ->count(); ?>
        @if ($orderCount > 0)
        <span class="pull-right-container">
            <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
        </span>
        @endif
        </a>
        </li>
        @endif
        @endif
        @if (in_array(2, $user_type))

        @if (in_array('show_order_res', $permissionsTitle))
        <li>
            <a href="{{ route('client-orders.index') }}/?notDelegated2">
                <i class="fa fa-sitemap"></i> <span class="text-wrap"
                    style="display:flex;width: 16.5rem;overflow: hidden;white-space: normal;word-wrap: break-word;">{{ __('admin_message.Transferring requests from restaurant') }}</span>
                <?php $orderCount = \App\Models\Order::NotDelegatedRes()
                    ->where('is_returned', 0)
                    ->where('company_id', Auth()->user()->company_id)
                    ->count(); ?>
                @if ($orderCount > 0)
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">{{ $orderCount }}</small>
                </span>
                @endif
            </a>
        </li>


        @endif
        @endif --}}

            @if (in_array('report_order_lastmile', $permissionsTitle) ||
                    in_array('report_order_resturant', $permissionsTitle) ||
                    in_array('report_order_fulfillment', $permissionsTitle) ||
                    in_array('report_accounting_lastmile', $permissionsTitle) ||
                    in_array('report_accounting_resturant', $permissionsTitle) ||
                    in_array('report_accounting_fulfillment', $permissionsTitle))
                <!-- Reports But not permmision yet -->
                <li
                    class="treeview {{ request()->routeIs('orderDerlivaryReport*') ? 'active' : '' }} {{ request()->routeIs('Export_Reports_excel*') ? 'active' : '' }}  {{ request()->routeIs('Export_Accounting_excel*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-regular fa-file"></i><span>{{ __('admin_message.Reports') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(1, $user_type))

                            @if (in_array('report_order_lastmile', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Reports_excel?work_type=1' ? 'active' : '' }}">
                                    <a href="{{ route('Export_Reports_excel.index', ['work_type' => 1]) }}">
                                        {{ __('admin_message.Last Mile Orders Report') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(4, $user_type))

                            @if (in_array('report_order_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Reports_excel?work_type=4' ? 'active' : '' }}">

                                    <a href="{{ route('Export_Reports_excel.index', ['work_type' => 4]) }}">
                                        {{ __('admin_message.Fulfillment Orders Report') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type))
                            @if (in_array('report_order_resturant', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Reports_excel?work_type=2' ? 'active' : '' }}">

                                    <a href="{{ route('Export_Reports_excel.index', ['work_type' => 2]) }}">
                                        {{ __('admin_message.Restaurant  Orders Report') }} </span>
                                        </span>
                                    </a>
                                </li>
                                @if (Auth()->user()->company_id == 2)
                                    <li class=" {{ request()->routeIs('orderDerlivaryReport*') ? 'active' : '' }} ">

                                        <a href="{{ route('orderDerlivaryReport.index', ['work_type' => 2]) }}">
                                            {{ __('admin_message.Restaurant  Orders Report Derlivary') }} </span>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                        <!-- accounting -->
                        @if (in_array(1, $user_type))

                            @if (in_array('report_accounting_lastmile', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Accounting_excel?work_type=1' ? 'active' : '' }}">
                                    <a href="{{ route('Export_Accounting_excel.index', ['work_type' => 1]) }}">
                                        {{ __('admin_message.Last Mile Accounting Report') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(4, $user_type))

                            @if (in_array('report_accounting_fulfillment', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Accounting_excel?work_type=4' ? 'active' : '' }}">

                                    <a href="{{ route('Export_Accounting_excel.index', ['work_type' => 4]) }}">
                                        {{ __('admin_message.Fulfillment Accounting Report') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('report_accounting_cod', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Accounting_to_excel/cod' ? 'active' : '' }}">
                                    <a href="{{ route('Export_Accounting_excel.cod') }}">
                                        {{ __('admin_message.Cod Accounting Report') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (in_array(2, $user_type))
                            @if (in_array('report_accounting_resturant', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/Export_Accounting_excel?work_type=2' ? 'active' : '' }}">
                                    <a href="{{ route('Export_Accounting_excel.index', ['work_type' => 2]) }}">
                                        {{ __('admin_message.Restaurant Accounting Report') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endif



                        <!-- end -->

                    </ul>
                </li>
            @endif


            <!-- end -->


            @if (in_array(1, $user_type))

                @if (in_array('show_dailyReport', $permissionsTitle) || in_array('add_dailyReport', $permissionsTitle))

                    <li class="treeview {{ request()->routeIs('DailyReport*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-regular fa-file"></i><span>{{ __('admin_message.External Reports') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('add_dailyReport', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/DailyReport/create' ? 'active' : '' }}">
                                    <a href="{{ route('DailyReport.create') }}">
                                        {{ __('admin_message.Add External Reports') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('show_dailyReport', $permissionsTitle))
                                <li class="{{ request()->getRequestUri() == '/admin/DailyReport' ? 'active' : '' }}">
                                    <a href="{{ route('DailyReport.index') }}">
                                        {{ __('admin_message.External Reports') }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
           

            <!-- ware house setting -->
            @if (in_array(3, $user_type) || in_array(4, $user_type))

                @if (in_array('show_warehouse_branches', $permissionsTitle))
                    <li
                        class="{{ request()->routeIs('warehouse_branches.index') ? 'active' : '' }} {{ request()->routeIs('warehouse_branches.edit') ? 'active' : '' }}  {{ request()->routeIs('warehouse_branches.create') ? 'active' : '' }}{{ request()->routeIs('warehouse_package*') ? 'active' : '' }}  {{ request()->routeIs('warehouse_floor*') ? 'active' : '' }}   {{ request()->routeIs('warehouse_areas*') ? 'active' : '' }}  {{ request()->routeIs('warehouse_stand*') ? 'active' : '' }}  ">
                        <a href="{{ route('warehouse_branches.index') }}">
                            <i class="fa fa-sitemap"></i> {{ __('admin_message.Warehouse Branches') }}</span>
                            </span>
                        </a>
                    </li>

                    <!-- search for pallet or shelves -->
                    <li class="{{ request()->routeIs('warehouse_branches.search') ? 'active' : '' }}">
                        <a href="{{ route('warehouse_branches.search') }}">
                            <i class="fa fa-sitemap"></i> {{ __('admin_message.Search for palette') }}</span>
                            </span>
                        </a>
                    </li>
                @endif

                @if (in_array('show_goods', $permissionsTitle) ||
                        in_array('show_category', $permissionsTitle) ||
                        in_array('show_sizes', $permissionsTitle) ||
                        in_array('show_box', $permissionsTitle))

                    <li
                        class="treeview {{ request()->routeIs('goods*') ? 'active' : '' }} {{ request()->routeIs('categories*') ? 'active' : '' }} {{ request()->routeIs('sizes*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-regular fa-circle-user"></i> <span>{{ __('admin_message.Goods') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if (in_array('show_goods', $permissionsTitle))
                                <li class=" {{ request()->routeIs('goods*') ? 'active' : '' }}">
                                    <a href="{{ route('goods.index') }}">
                                        <i class="fa fa-sitemap"></i> <span> {{ __('admin_message.Goods') }}</span>


                                    </a>
                                </li>
                            @endif
                            @if (in_array('show_category', $permissionsTitle))
                                <li class="{{ request()->routeIs('categories*') ? 'active' : '' }}"><a
                                        href="{{ route('categories.index') }}"><i class="fa fa-th"></i>
                                        {{ __('admin_message.Categories') }}</a></li>
                            @endif
                            @if (in_array('show_sizes', $permissionsTitle))
                                <li class="{{ request()->routeIs('sizes*') ? 'active' : '' }}">
                                    <a href="{{ route('sizes.index') }}">
                                        <i class="fa fa-sitemap"></i> <span> {{ __('admin_message.Sizes') }}</span>


                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                <!-- @if (in_array(4, $user_type))

                    @if (in_array('show_box', $permissionsTitle))
                        <li class="{{ request()->routeIs('boxs*') ? 'active' : '' }}">
                            <a href="{{ route('boxs.index') }}">
                                <i class="fa-solid fa-box"></i> <span> {{ __('admin_message.boxs') }}</span>


                            </a>
                        </li>
                    @endif
                @endif -->

                @if (in_array('QR_print', $permissionsTitle))
                    <li
                        class="{{ request()->routeIs('QR.index') ? 'active' : '' }} {{ request()->routeIs('QR.create') ? 'active' : '' }} {{ request()->routeIs('QR.store') ? 'active' : '' }}">

                        <a href="{{ route('QR.index') }}">
                            <i class="fa fa-sitemap"></i> <span> {{ __('admin_message.Print') }} QR</span>
                        </a>
                    </li>
                    {{-- <li>
            <a href="{{route('scan-orders.scan')}}">
        <i class="fa fa-sitemap"></i> <span> {{__('admin_message.Print')}} QR</span>
        </a>
        </li> --}}
                @endif
                @if (in_array('QR_print', $permissionsTitle))
                    <li
                        class="{{ request()->routeIs('QR.index2') ? 'active' : '' }} {{ request()->getRequestUri() == '/admin/generateQR/store' ? 'active' : '' }}">

                        <a href="{{ route('QR.index2') }}">
                            <i class="fa fa-sitemap"></i> <span>عدد QR</span>
                        </a>
                    </li>
                @endif
                @if (in_array('show_offers', $permissionsTitle))
                    <li class="{{ request()->routeIs('Packages*') ? 'active' : '' }}"><a
                            href="{{ route('Packages.index') }}"><i class="fa-brands fa-first-order"></i>
                            <span>{{ __('admin_message.Packages') }} </span></a></li>
                @endif

                @if (in_array('show_packaging_goods', $permissionsTitle))


                    <li
                        class="treeview {{ request()->routeIs('packages_goods.index') ? 'active' : '' }} {{ request()->routeIs('packages_goods.create') ? 'active' : '' }} {{ request()->routeIs('packages_good.scan') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-brands fa-first-order"></i>
                            <span>{{ __('admin_message.Inventory Management') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">



                            @if (in_array('show_packaging_goods', $permissionsTitle))
                                <li
                                    class="{{ request()->getRequestUri() == '/admin/packages_goods?type=1' ? 'active' : '' }}   {{ request()->getRequestUri() == '/admin/packages_goods/create?type=1' ? 'active' : '' }} ">
                                    <a href="{{ route('packages_goods.index', ['type' => 1]) }}"><i
                                            class="fa-brands fa-first-order"></i>
                                        <span> {{ __('fulfillment.warehouse_stock') }} </span></a></li>
                            @endif
                            <!--  -->
                            @if (in_array(4, $user_type))
                                @if (in_array('show_packaging_goods', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/packages_goods?type=2' ? 'active' : '' }}  {{ request()->getRequestUri() == '/admin/packages_goods/create?type=2' ? 'active' : '' }}">
                                        <a href="{{ route('packages_goods.index', ['type' => 2]) }}"><i
                                                class="fa-brands fa-first-order"></i>
                                            <span> {{ __('fulfillment.fulfillment_stock') }} </span></a></li>
                                @endif
                            @endif
                            <!-- @if (in_array(4, $user_type))
                                @if (in_array('show_damagened_orders', $permissionsTitle))
                                    <li
                                        class="{{ request()->getRequestUri() == '/admin/damaged-goods' ? 'active' : '' }}  {{ request()->getRequestUri() == '/admin/packages_goods/create?type=2' ? 'active' : '' }}">
                                        <a href="{{ route('damaged-goods.index') }}"><i
                                                class="fa-brands fa-first-order"></i>
                                            <span> {{ __('admin_message.Damaged Goods') }} </span></a></li>
                                @endif
                            @endif -->
                        </ul>
                    </li>
                @endif

                @if (in_array('show_packaging_goods', $permissionsTitle))
                    <li
                        class="treeview {{ request()->routeIs('packages_good.search') ? 'active' : '' }} {{ request()->routeIs('packages_good.clientSearch') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-brands fa-first-order"></i>
                            <span>{{ __('fulfillment.search_stock') }}</span>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ request()->routeIs('packages_good.search') ? 'active' : '' }}">
                                <a href="{{ route('packages_good.search') }}">
                                    <span> جرد منتج

                                    </span></a>
                            </li>
                            <li class="{{ request()->routeIs('packages_good.clientSearch') ? 'active' : '' }}"><a
                                    href="{{ route('packages_good.clientSearch') }}">
                                    <span> جرد منتجات عميل</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif

            <!-- ware house settings -->

            <!-- الموظفين  -->
            @if (in_array('show_user', $permissionsTitle) ||
                    in_array('show_supervisor', $permissionsTitle) ||
                    in_array('show_role', $permissionsTitle))

                <li
                    class="treeview {{ request()->routeIs('users*') ? 'active' : '' }} {{ request()->routeIs('supervisor*') ? 'active' : '' }} {{ request()->routeIs('roles*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-regular fa-circle-user"></i>
                        <span>{{ __('admin_message.Users and Permissions') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>


                    <ul class="treeview-menu">
                        @if (in_array('show_user', $permissionsTitle))
                            <li class="{{ request()->routeIs('users*') ? 'active' : '' }}"><a
                                    href="{{ route('users.index') }}"> {{ __('admin_message.Users') }}</a></li>
                        @endif
                        @if (in_array(1, $user_type) || in_array(2, $user_type))

                            @if (in_array('show_supervisor', $permissionsTitle))
                                <li class="{{ request()->routeIs('supervisor*') ? 'active' : '' }}"><a
                                        href="{{ route('supervisor.index') }}">
                                        {{ __('admin_message.Supervisor') }}</a></li>
                            @endif
                        @endif


                        @if (in_array('show_role', $permissionsTitle))
                            <li class="{{ request()->routeIs('roles*') ? 'active' : '' }}"><a
                                    href="{{ route('roles.index') }}"> {{ __('admin_message.Roles') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('show_status', $permissionsTitle))
            <li class="treeview {{ request()->routeIs('statuses*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa-regular fa-circle-user"></i>
                    <span>{{ __('admin_message.statuses') }}</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('statuses.index') }}">
                            <i class="fa fa-sitemap"></i> <span>{{ __('admin_message.statuses') }}</span>
                        </a>
                    </li>
                    @if (in_array('show_partners_statuses', $permissionsTitle))
                    <li>
                        <a href="{{ route('foodics_statuses.show') }}">
                            <i class="fa fa-sitemap"></i> <span>{{ __('app.partners_statuses') }}</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            <!-- here -->
            @if (in_array('show_Orders_rules', $permissionsTitle) ||
                    in_array('add_Orders_rules', $permissionsTitle) ||
                    in_array('show_orders_rules_service_provider', $permissionsTitle) ||
                    in_array('add_orders_rules_service_provider', $permissionsTitle) ||
                    in_array('show_city', $permissionsTitle) ||
                    in_array('show_neighborhood', $permissionsTitle) ||
                    in_array('show_CityZone', $permissionsTitle) ||
                    in_array('show_RegionZone', $permissionsTitle) ||
                    in_array('show_branch', $permissionsTitle) ||
                    in_array('edit_adminSetting', $permissionsTitle))
                <li
                    class="treeview {{ request()->routeIs('settings*') ? 'active' : '' }} {{ request()->routeIs('Company_branches*') ? 'active' : '' }} {{ request()->routeIs('CityZone*') ? 'active' : '' }}  {{ request()->routeIs('RegionZone*') ? 'active' : '' }} {{ request()->routeIs('AssignOrdersRule*') ? 'active' : '' }} {{ request()->routeIs('Rule_service_provider*') ? 'active' : '' }} {{ request()->routeIs('CityCompany*') ? 'active' : '' }}  {{ request()->routeIs('RegionCompany*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>{{ __('admin_message.Settings') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (in_array(2, $user_type) || in_array(1, $user_type) || in_array(4, $user_type))

                            @if (in_array('show_Orders_rules', $permissionsTitle) || in_array('add_Orders_rules', $permissionsTitle))

                                <li class="treeview {{ request()->routeIs('AssignOrdersRule*') ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa-regular fa-circle-user"></i> <span>
                                            {{ __('admin_message.Rules for Appointing Delegates') }} </span>
                                        <span class="pull-right-container">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        @if (in_array('show_Orders_rules', $permissionsTitle))
                                            <li
                                                class="{{ request()->routeIs('AssignOrdersRule.index') ? 'active' : '' }} {{ request()->routeIs('AssignOrdersRule.edit') ? 'active' : '' }}">
                                                <a href="{{ route('AssignOrdersRule.index') }}">
                                                    {{ __('admin_message.Rules for Appointing Delegates') }} </a></li>
                                        @endif
                                        @if (in_array('add_Orders_rules', $permissionsTitle))
                                            <li
                                                class="{{ request()->routeIs('AssignOrdersRule.create') ? 'active' : '' }}">
                                                <a href="{{ route('AssignOrdersRule.create') }}">{{ __('admin_message.Add') }}
                                                </a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif

                        <!-- Assign to service provider -->
                        @if (in_array(2, $user_type) || in_array(1, $user_type) || in_array(4, $user_type))

                            @if (in_array('show_orders_rules_service_provider', $permissionsTitle) ||
                                    in_array('add_orders_rules_service_provider', $permissionsTitle))

                                <li
                                    class="treeview {{ request()->routeIs('Rule_service_provider*') ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa-regular fa-circle-user"></i> <span>
                                            {{ __('admin_message.Rules for Appointing service provider') }} </span>
                                        <span class="pull-right-container">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        @if (in_array('show_orders_rules_service_provider', $permissionsTitle))
                                            <li
                                                class="{{ request()->routeIs('Rule_service_provider.index') ? 'active' : '' }} {{ request()->routeIs('Rule_service_provider.edit') ? 'active' : '' }}">
                                                <a href="{{ route('Rule_service_provider.index') }}">
                                                    {{ __('admin_message.Rules for Appointing service provider') }}
                                                </a></li>
                                        @endif
                                        @if (in_array('add_orders_rules_service_provider', $permissionsTitle))
                                            <li
                                                class="{{ request()->routeIs('Rule_service_provider.create') ? 'active' : '' }}">
                                                <a href="{{ route('Rule_service_provider.create') }}">{{ __('admin_message.Add') }}
                                                </a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif
                        <!-- end  -->

                        <!-- cites & regions -->
                        @if (in_array('show_city', $permissionsTitle) || in_array('show_neighborhood', $permissionsTitle))

                            <li
                                class="treeview {{ request()->routeIs('CityCompany*') ? 'active' : '' }}  {{ request()->routeIs('RegionCompany*') ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa-solid fa-shop"></i> <span> {{ __('admin_message.City & Region') }}
                                    </span>
                                    <span class="pull-right-container">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </span>
                                </a>


                                <ul class="treeview-menu">
                                    @if (in_array('show_city', $permissionsTitle))
                                        <li class="{{ request()->routeIs('CityCompany.create') ? 'active' : '' }}"><a
                                                href="{{ route('CityCompany.create') }}">{{ __('admin_message.Add') }}
                                                {{ __('admin_message.City') }}</a></li>
                                    @endif
                                    @if (in_array('add_city', $permissionsTitle))
                                        <li
                                            class="{{ request()->routeIs('CityCompany.index') ? 'active' : '' }} {{ request()->routeIs('CityCompany.edit') ? 'active' : '' }}">
                                            <a href="{{ route('CityCompany.index') }}">
                                                {{ __('admin_message.City') }}</a>
                                        </li>
                                    @endif
                                    @if (in_array('add_neighborhood', $permissionsTitle))
                                        <li class="{{ request()->routeIs('RegionCompany.create') ? 'active' : '' }}">
                                            <a href="{{ route('RegionCompany.create') }}">{{ __('admin_message.Add') }}
                                                {{ __('admin_message.Regions') }} </a></li>
                                    @endif
                                    @if (in_array('show_neighborhood', $permissionsTitle))
                                        <li
                                            class="{{ request()->routeIs('RegionCompany.index') ? 'active' : '' }} {{ request()->routeIs('RegionCompany.edit') ? 'active' : '' }}">
                                            <a
                                                href="{{ route('RegionCompany.index') }}">{{ __('admin_message.Regions') }}</a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        @endif



                        <!-- end -->
                        @if (in_array(1, $user_type))
                            @if (in_array('show_CityZone', $permissionsTitle) || in_array('show_RegionZone', $permissionsTitle))

                                <li
                                    class="treeview {{ request()->routeIs('CityZone*') ? 'active' : '' }}  {{ request()->routeIs('RegionZone*') ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa-solid fa-shop"></i> <span>
                                            {{ __('admin_message.City and Regional Tilr') }}
                                        </span>
                                        <span class="pull-right-container">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        @if (in_array('show_CityZone', $permissionsTitle))
                                            <li class="{{ request()->routeIs('CityZone*') ? 'active' : '' }}"><a
                                                    href="{{ route('CityZone.index') }}">
                                                    {{ __('admin_message.City Tilrs') }}</a></li>
                                        @endif
                                        @if (in_array('show_RegionZone', $permissionsTitle))
                                            <li class="{{ request()->routeIs('RegionZone*') ? 'active' : '' }}"><a
                                                    href="{{ route('RegionZone.index') }}">{{ __('admin_message.Neighborhood Tilrs') }}
                                                </a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                        @endif
                        <!-- end zone -->
                        @if (in_array(1, $user_type))

                            @if (in_array('show_branch', $permissionsTitle))
                                <li class=" {{ request()->routeIs('Company_branches*') ? 'active' : '' }}">
                                    <a href="{{ route('Company_branches.index') }}"><i
                                            class="fa fa-map"></i>{{ __('admin_message.Branches') }}</a>
                                </li>
                            @endif
                        @endif
                        @if (in_array('edit_adminSetting', $permissionsTitle))
                            <li class="treeview {{ request()->routeIs('settings*') ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa-solid fa-shop"></i> <span> {{ __('admin_message.Settings') }}
                                    </span>
                                    <span class="pull-right-container">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="{{ request()->routeIs('settings.edit.company') ? 'active' : '' }}"><a
                                            href="{{ route('settings.edit.company') }}">
                                            {{ __('admin_message.Global Settings') }}</a></li>


                                    <li class="{{ request()->routeIs('settings.edit.status') ? 'active' : '' }}"><a
                                            href="{{ route('settings.edit.status') }}">
                                            {{ __('admin_message.status Settings') }}
                                        </a></li>

                                    @if (in_array(3, $user_type) || in_array(4, $user_type))
                                        <li
                                            class="{{ request()->routeIs('settings.edit.warehouse') ? 'active' : '' }}">
                                            <a href="{{ route('settings.edit.warehouse') }}">
                                                {{ __('admin_message.Warehouses settings') }}
                                            </a></li>
                                    @endif


                                    <li class="{{ request()->routeIs('settings.edit.terms') ? 'active' : '' }}"><a
                                            href="{{ route('settings.edit.terms') }}">
                                            {{ __('admin_message.Terms & conditions Settings') }}
                                        </a></li>


                                </ul>
                            </li>

                        @endif
            @endif
        </ul>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
