<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('storage/'.Auth()->user()->avatar)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth()->user()->name}}</p>
                @php 
                $de_s=Auth()->user()->SupervisorDelegate()->pluck('delegate_id')->toArray();
                $shop=\App\Models\User::whereIn('id',$de_s)->where('work',1)->count();
                // dd($shop);

                @endphp
                @php 
                $res=\App\Models\User::whereIn('id',$de_s)->where('work',2)->count();
                // dd($res);
                @endphp

            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ __('admin_message.Main menus') }}</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="/{{Auth()->user()->user_type}}">
                    <i class="fa fa-dashboard"></i> <span>@lang('app.dashboard')</span>
                    </span>
                </a>
            </li>
            {{-- @if($user_type==1) --}}

            @if($shop>0)
            <li class="{{ request()->routeIs('supervisororders.shipToday', 1) ? 'active' : '' }}">

                <a href="{{route('supervisororders.shipToday',1)}}">
                    <i class="fa  fa-truck"></i> <span> {{ __('app.Orders_Ship_today') }} </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @endif
            {{-- @if($user_type==2) --}}

            @if($res>0)

            <li class="{{ request()->routeIs('supervisororders.shipToday', 2) ? 'active' : '' }}">
                <a href="{{route('supervisororders.shipToday',2)}}">
                    <i class="fa  fa-truck"></i> <span> @lang('app.resturant_orders_today') </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @endif
            {{-- @if($user_type==1) --}}

            @if($shop>0)


            <li class="{{ request()->routeIs('supervisor-delegates.index', ['type' => 1]) ? 'active' : '' }}">
                <a href="{{route('supervisor-delegates.index', ['type' => 1])}}">
                    <i class="fa-solid fa-truck"></i><span> @lang('app.stores delegats')</span>
                    </span> </a></li>
            {{-- @endif --}}
            @endif
            {{-- @if($user_type==2) --}}

            @if($res>0)

            <li class="{{ request()->routeIs('supervisor-delegates.index', ['type' => 2]) ? 'active' : '' }}">
                <a href="{{route('supervisor-delegates.index', ['type' => 2])}}">
                    <i class="fa-solid fa-truck-fast"></i> <span> @lang('app.resturants delegats') </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @endif
            {{-- @if($user_type==1) --}}

            @if($shop>0)

            <li class="{{ request()->routeIs('supervisororders.index') && request()->query('work_type') == 1 ? 'active' : '' }}">
                <a href="{{route('supervisororders.index',['work_type'=>1])}}">
                    <i class="fa fa-shopping-bag"></i> <span> @lang('app.shop_orders') </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @endif
            {{-- @if($user_type==2) --}}

            @if($res>0)

            <li class="{{ request()->routeIs('supervisororders.index') && request()->query('work_type') == 2 ? 'active' : '' }}">
                <a href="{{route('supervisororders.index',['work_type'=>2])}}">
                    <i class="fa fa-shopping-bag"></i> <span> @lang('app.restaurant_orders') </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @endif
            @if(Auth()->user()->show_report==1)

            <li class="{{ request()->routeIs('supervisor_DayReport.index') ? 'active' : '' }}">
                <a href="{{route('supervisor_DayReport.index')}}">
                    <i class="fa fa-file"></i> <span> @lang('app.Daily_Reports')</span>
                    </span>
                </a>
            </li>
            @endif




        </ul>
    </section>
    <!-- /.sidebar -->
</aside>