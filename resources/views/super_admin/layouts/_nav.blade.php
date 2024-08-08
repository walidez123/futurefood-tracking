<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header strong"> @lang('admin_message.Main menus')  </li>
            <li class="active">
                <a href="/{{Auth()->user()->user_type}}">
                    <i class="fa-solid fa-house"></i> <span>@lang('app.dashboard')</span>
                    </span>
                </a>
            </li>
            <!-- end client -->

            <li class="treeview">
                <a href="#">
                    <i class="fa-regular fa-circle-user"></i> <span>إدارة الحسابات</span>
                    <span class="pull-right-container">
                        <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (in_array('add_client', $permissionsTitle))
                    <li><a href="{{ route('companies.create') }}"><i class="fa-solid fa-circle-plus"></i> أضافة شركة
                        </a></li>
                    @endif
                    @if (in_array('show_client', $permissionsTitle))

                    <li><a href="{{route('companies.index')}}"><i class="fa-solid fa-basket-shopping"></i> الشركات</a>
                    </li>
                    @endif
                </ul>
            </li>
           

                <li class="treeview {{ request()->routeIs('service_provider*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa-regular fa-circle-user"></i>
                        <span> {{ __('admin_message.Service provider') }}</span>
                        <span class="pull-right-container">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                            <li class="{{ request()->routeIs('service_provider.create') ? 'active' : '' }}">
                                <a href="{{ route('service_provider.create') }}">@lang('admin_message.add Service provider')</a>
                            </li>

                            <li class="{{ request()->routeIs('service_provider.index') ? 'active' : '' }}">

                                <a href="{{ route('service_provider.index') }}">
                                    {{ __('admin_message.Service provider') }} </a>
                            </li>


                    </ul>
                </li>
            
            <!--  -->
            <li class="treeview">
                <a href="#">
                    <i class="fa-regular fa-circle-user"></i> <span> طلبات الأنضمام</span>
                    <?php $orderCount = \App\Models\Request_join_user::where('is_read',0)->count();
                          $orderCount2 = \App\Models\Request_join_service_provider::where('is_read',0)->count();
                          $orderCount3=$orderCount+$orderCount2;
                     ?>
                    @if ($orderCount3 > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$orderCount3}}</small>
                    </span>
                    @endif 
                    <!-- <span class="pull-right-container">
                        <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span> -->
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('delegate_request_join.index') }}"><i class="fa-solid fa-circle-plus"></i> طلب
                            أنضمام كمندوب 
                            @if ($orderCount > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$orderCount}}</small>
                    </span>
                    @endif 
                        </a></li>
                    <li><a href="{{ route('request_join_service_provider.index') }}"><i
                                class="fa-solid fa-circle-plus"></i> طلب أنضمام الشركات المشغلة  
                                @if ($orderCount2 > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$orderCount2}}</small>
                    </span>
                    @endif </a></li>
                </ul>
            </li>
            <!--  -->
            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('request-joins.index')}}">
                    <i class="fa fa-handshake"></i> <span>طلب الخدمه</span>
                    <?php $requestCount = \App\Models\RequestJoin::where('is_readed', 0)->count() ?>
                    @if ($requestCount > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$requestCount}}</small>
                    </span>
                    @endif

                </a>
            </li>

            @endif
            <li>
                <a href="{{ route('companies.balances')}}">
                    <i class="fa-solid fa-file-invoice-dollar"></i> <span>{{ __('admin_message.Accounting') }}</span>
                </a>
            </li>
            <!--  -->
            @if (in_array('show_city', $permissionsTitle)||in_array('add_city',
            $permissionsTitle)||in_array('show_region', $permissionsTitle)||in_array('add_region', $permissionsTitle))

            <li class="treeview">
                <a href="#">
                    <i class="fa-solid fa-shop"></i> <span>المدن و المناطق</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>


                <ul class="treeview-menu">

                    @if(in_array('add_city', $permissionsTitle))
                    <li><a href="{{route('cities.create')}}"> أضافة مدينة </a></li>
                    @endif
                    @if(in_array('show_city', $permissionsTitle))

                    <li><a href="{{route('cities.index')}}"> المدن</a></li>
                    @endif

                    @if(in_array('add_neighborhood', $permissionsTitle))

                    <li><a href="{{route('neighborhoods.create')}}"> أضافة حى</a></li>
                    @endif

                    @if(in_array('show_neighborhood', $permissionsTitle))

                    <li><a href="{{route('neighborhoods.index')}}"> الأحياء</a></li>
                    @endif
                    
                </ul>
            </li>
            @endif   
            
            <li class="treeview {{ request()->routeIs('provinces*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa-regular fa-circle-user"></i>
                    <span> Provinces</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                        <li class="{{ request()->routeIs('provinces.create') ? 'active' : '' }}">
                            <a href="{{ route('provinces.create') }}"> إضافة province</a>
                        </li>

                        <li class="{{ request()->routeIs('provinces.index') ? 'active' : '' }}">

                            <a href="{{ route('provinces.index') }}">
                                Provinces </a>
                        </li>


                </ul>
            </li>
            <li>
                <a href="{{route('transfer-clients')}}">
                    <i class="fa fa-landmark"></i> <span>تحويل الشركات</span>
                </a>
            </li>
            <li>
                <a href="{{route('monthly-reports.index')}}">
                    <i class="fa fa-file"></i> <span>تقارير الشركات</span>
                </a>
            </li>
            <li>
                <a href="{{route('search_order.index')}}">
                    <i class="fa fa-search"></i> <span>بحث الطلبات</span>
                </a>
            </li>
            <li>
                <a href="{{route('defult_status.index')}}">
                    <i class="fa fa-sitemap"></i> <span>الحالات </span>
                </a>
            </li>
            <!--  -->
            <li><a href="{{route('appSettings.edit')}}"><i class="fa fa-cog"></i> إعدات التطبيق</a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa-regular fa-circle-user"></i> <span> الإشعارات</span>
                    <span class="pull-right-container">
                        <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('notificationFCM.create')}}"><i class="fa fa-cog"></i> إرسال إشعار للمناديب</a>
                    </li>

                    <li><a href="{{route('notificationFCM.index')}}"><i class="fa fa-cog"></i>الأشعارات</a></li>
                </ul>
            </li>





            <li class="treeview">
                <a href="#">
                    <i class="fa fa-globe"></i> <span>الموقع</span>
                    <span class="pull-right-container">
                        <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    {{-- @if (in_array('show_slider', $permissionsTitle)) --}}
                    <li><a href="{{route('sliders.index')}}"><i class="fa fa-window-restore"></i> Slider</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_page', $permissionsTitle)) --}}
                    <li><a href="{{route('pages.index')}}"><i class="fa fa-file-text"></i> pages</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_post', $permissionsTitle)) --}}
                    <li><a href="{{route('solutions.index')}}"><i class="fa fa-wrench"></i> Solutions</a></li>

                    <li><a href="{{route('posts.index')}}"><i class="fa fa-newspaper-o"></i> Posts</a></li>
                    {{-- @endif --}}
                  
                    {{-- @if (in_array('show_service', $permissionsTitle)) --}}
                    <li><a href="{{route('services.index')}}"><i class="fa fa-first-order"></i> Service</a></li>
                    {{-- @endif
                    @if (in_array('show_whatWeDo', $permissionsTitle)) --}}
                    <li><a href="{{route('what-we-do.index')}}"><i class="fa fa-question-circle"></i> What We Do</a>
                    </li>
                    {{-- @endif --}}
                  
                    {{-- @if (in_array('show_contactUs', $permissionsTitle)) --}}
                    <li><a href="{{route('contacts.index')}}"><i class="fa fa-envelope-o"></i> Contact us</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_partner', $permissionsTitle)) --}}
                    <li><a href="{{route('partner-categories.index')}}"><i class="fa fa-envelope-o"></i> partner categories</a></li>
                    <li><a href="{{route('partners.index')}}"><i class="fa fa-envelope-o"></i> partners</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_contactUs', $permissionsTitle)) --}}
                    <li><a href="{{route('testimoinals.index')}}"><i class="fa fa-envelope-o"></i> Testimoinals</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_contactUs', $permissionsTitle)) --}}
                    <li><a href="{{route('faqs.index')}}"><i class="fa fa-envelope-o"></i> Faqs</a></li>
                    {{-- @endif --}}
                    {{-- @if (in_array('show_contactUs', $permissionsTitle)) --}}
                    <li><a href="{{route('counters.index')}}"><i class="fa fa-envelope-o"></i> Counter</a></li>
                    <li><a href="{{route('subscription.index')}}"><i class="fa fa-subscript"></i> subscription</a></li>

                    {{-- @endif --}}
                    {{-- @if (in_array('edit_websiteSetting', $permissionsTitle)) --}}
                    <li><a href="{{route('settings.edit')}}"><i class="fa  fa-cog"></i> Settings</a></li>
                    {{-- @endif --}}
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>