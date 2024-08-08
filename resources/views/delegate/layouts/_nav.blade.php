<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        @php $works=\App\Models\Delegate_work::where('delegate_id',Auth()->user()->id)->pluck('work')->toArray();   @endphp
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('storage/'.Auth()->user()->avatar)}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth()->user()->name}}</p>

                </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">{{ __('admin_message.Main menus') }}</li>
                <li class="active">
                    <a href="/{{Auth()->user()->user_type}}">
                        <i class="fa fa-dashboard"></i> <span>@lang('app.dashboard')</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('delegate-orders.index')}}?shipToday">
                        <i class="fa  fa-truck"></i> <span>@lang('app.Orders_Ship_today')</span>
                        </span>
                    </a>
                </li>
                @if(in_array(1,$works))
                    <li>
                        <a href="{{route('delegate-orders.index')}}?stores">
                            <i class="fa fa-shopping-bag"></i> <span>@lang('app.shop_orders')</span>
                            </span>
                        </a>
                    </li>
                @endif
                @if(in_array(2,$works))

                    <li>
                        <a href="{{route('delegate-orders.index')}}?restaurants">
                            <i class="fa fa-shopping-bag"></i> <span>@lang('app.restaurant_orders')</span>
                            </span>
                        </a>
                    </li>
                @endif
                @if(in_array(4,$works))

                    <li>
                        <a href="{{route('delegate-orders.index')}}?fulfillments">
                            <i class="fa fa-shopping-bag"></i> <span>@lang('fulfillment.fulfillment_Orders')</span>
                            </span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{route('transactions.delegate')}}">
                        <i class="fa-solid fa-money-bill-transfer"></i> <span>@lang('app.Balance_Transactions')</span>
                        </span>
                    </a>
                </li>
                 @if(Auth()->user()->show_report==1)

                 <li class="">
                    <a href="{{route('DayReport.index')}}">
                        <i class="fa fa-dashboard"></i> <span>@lang('app.Daily_Reports')</span>
                        </span>
                    </a>
                </li>
                @endif




            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>