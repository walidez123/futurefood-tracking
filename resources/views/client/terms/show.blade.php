<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Future Express</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/skins/_all-skins.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

   
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{route('client.dashboard')}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>{{Auth()->user()->company_setting->trans('title')}}</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{Auth()->user()->company_setting->trans('title')}}</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if ($lang == 'ar')
                        <li>
                            <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" title=""><i
                                    class="fa fa-language" aria-hidden="true"></i> English</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" title=""><i
                                    class="fa fa-language" aria-hidden="true"></i> العربية </a>
                        </li>
                        @endif
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('storage/'.Auth()->user()->avatar)}}" class="user-image"
                                    alt="{{Auth()->user()->name}}">
                                <span class="hidden-xs">{{Auth()->user()->name}} </span>
                            </a>
                            <ul class="dropdown-menu">

                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{asset('storage/'.Auth()->user()->avatar)}}" class="img-circle"
                                        alt="{{Auth()->user()->name}}">

                                    <p>
                                        {{Auth()->user()->name}}
                                        <small>{{Auth()->user()->user_type}} </small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <a href="#"></a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#"></a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#"></a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Sign out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->

                    </ul>
                </div>
            </nav>
        </header>
     
       
        <!-- Content Wrapper. Contains page content -->
        <div class="content">
            
            <button onclick="window.print()" style="margin-top:15px; " class="btn btn-primary"><i class="fa fa-print"
                    style=" padding:5px"></i> @lang('app.terms_and_condition')</button>
            <!-- Content Header (Page header) -->
            <section class="content-header text-center col-xs-12 col-md-8 col-md-offset-2">
                <h1 style="font-size: 50px; font-weight: bold; padding-top:20px; ">
                    @lang('app.terms_and_condition')
                </h1>

            </section>

            @if((auth()->user()->work==1 || auth()->user()->work==4) && auth()->user()->user_type='client')

            <!-- Main content -->
            <section class="content">
                  
                <div class="container">
                   <div class="row">
                        
                             <div class="col-xs-12">
                            @if((auth()->user()->work==1))
                            <div class="col-xs-6">
                                {!! auth()->user()->company_setting->terms_en !!}
                            </div>
                            <div style="text-align: right" class="col-xs-6">
                                {!! auth()->user()->company_setting->terms_ar !!}
                            </div>
                            @elseif(auth()->user()->work==4)
                            <div class="col-xs-6">
                                {!! auth()->user()->company_setting->term_en_fulfillment !!}
                            </div>
                            <div style="text-align: right" class="col-xs-6">
                                {!! auth()->user()->company_setting->term_ar_fulfillment !!}
                            </div>

                            @endif
                          </div> 
                       
                   </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 ">

                        <div class="col-xs-12">
                            <hr>
                        </div>
                       
                        <div class="col-xs-12">
                        <div class="table">

                            <table class="table   table-bordered table-striped">

                                <thead>
                                    <tr>
                                    @if(auth()->user()->cost_type==1)

                                        <th>@lang('app.cost_inside_same_city')</th>
                                        <th>@lang('app.cost_outside_city')</th>
                                        <th>@lang('app.cost_for_Reshipping')</th>
                                        <th>@lang('app.cost_reshipping_out_city')</th>
                                        <th>@lang('app.fees_for_cash')</th>
                                        <th>@lang('app.fees_for_cash_outside')</th>
                                        <th>@lang('app.tax')</th>
                                        <th>@lang('app.standard_weight')</th>
                                        <th>@lang('app.standard_weight_outside')</th>
                                        <th>@lang('app.over_weight_per_kilo')</th>
                                        <th>@lang('app.over_weight_per_kilo_outside')</th>
                                        <th>@lang('app.pickup_fees')</th>
                                    @endif
                                    @if(auth()->user()->cost_type==2)
                                    @foreach($zones as $zone)
                                    @if(count($Zone_accounts)>0)
                                    @foreach($Zone_accounts as $Zone_account)
                                    @if($Zone_account->zone_id==$zone->id)
                                        <th>{{__("admin_message.Delivery cost inside")}} {{$Zone_account->Zone->trans('title')}}</th>
                                        <th>{{__('admin_message.Delivery cost outside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.Reshipping cost inside')}} {{$zone->trans('title')}}</th>
                                        <th> {{__('admin_message.Reshipping cost outside')}} {{$zone->trans('title')}}</th>
                                        <th> {{__('admin_message.fees cost delivery inside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.fees cost delivery outside')}} {{$zone->trans('title')}}</th>
                                        <th>@lang('app.tax')</th>
                                        <th>{{__('admin_message.standard weight inside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.standard weight outside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.over weight per kilo inside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.over weight per kilo outside')}} {{$zone->trans('title')}}</th>
                                        <th>{{__('admin_message.fees pickup')}}</th>
                                        @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif


                                        @if(auth()->user()->work==4)
                                        <th>{{__('fulfillment.receive_palette')}}</th>
                                        <th> {{__('fulfillment.store_palette')}}</th>
                                        <th>{{__('fulfillment.sort_by_sku')}}</th>
                                        <th>{{__('fulfillment.pick_process_package')}}</th>
                                        <th> {{__('fulfillment.print_waybill')}}</th>
                                        <th>{{__('fulfillment.sort_by_city')}}</th>
                                        <th>{{__('fulfillment.store_return_shipment')}}</th>
                                        <th>{{__('fulfillment.reprocess_return_shipment')}}</th>
                                        @endif



                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    @if(auth()->user()->cost_type==1)

                                        <td>{{ auth()->user()->cost_inside_city}}</td>
                                        <td>{{ auth()->user()->cost_outside_city}}</td>
                                        <td>{{ auth()->user()->cost_reshipping}}</td>
                                        <td>{{ auth()->user()->cost_reshipping_out_city}}</td>
                                        <td>{{ auth()->user()->fees_cash_on_delivery }}</td>
                                        <td>{{ auth()->user()->fees_cash_on_delivery_out_city}}</td>
                                        <td>{{ auth()->user()->tax}}%</td>
                                        <td>{{ auth()->user()->standard_weight}}</td>
                                        <td>{{ auth()->user()->standard_weight_outside}}</td>
                                        <td>{{ auth()->user()->over_weight_per_kilo}}</td>
                                        <td>{{ auth()->user()->over_weight_per_kilo_outside}}</td>
                                        <td>{{ auth()->user()->pickup_fees}}</td>
                                    @endif
                                    @if(auth()->user()->cost_type==2)
                                    @foreach($zones as $zone)
                                    @if(count($Zone_accounts)>0)
                                    @foreach($Zone_accounts as $Zone_account)
                                    @if($Zone_account->zone_id==$zone->id)


                                    <td>{{ $Zone_account->cost_inside_zone}}</td>
                                        <td>{{ $Zone_account->cost_outside_zone}}</td>
                                        <td>{{ $Zone_account->cost_reshipping_zone}}</td>
                                        <td>{{ $Zone_account->cost_reshipping_out_zone}}</td>
                                        <td>{{ $Zone_account->fees_cash_on_delivery_zone }}</td>
                                        <td>{{ $Zone_account->fees_cash_on_delivery_out_zone}}</td>
                                        <td>{{ auth()->user()->tax}}%</td>
                                        <td>{{ $Zone_account->standard_weight_zone}}</td>
                                        <td>{{ $Zone_account->standard_weight_outside_zone}}</td>
                                        <td>{{ $Zone_account->over_weight_per_kilo_zone}}</td>
                                        <td>{{ $Zone_account->over_weight_per_kilo_outside_zone}}</td>
                                        <td>{{ $Zone_account->pickup_fees_zone}}</td>
                                    @endif
                                    @endforeach



                                    @endif
                                    @endforeach
                                    @endif

                                        @if(auth()->user()->work==4)
                                        @if(auth()->user()->userCost!=NULL)
                                        <td>{{ auth()->user()->userCost->receive_palette }}</td>
                                        <td>{{ auth()->user()->userCost->store_palette}}</td>
                                        <td>{{ auth()->user()->userCost->sort_by_suku}}%</td>
                                        <td>{{ auth()->user()->userCost->pick_process_package}}</td>
                                        <td>{{ auth()->user()->userCost->print_waybill}}</td>
                                        <td>{{ auth()->user()->userCost->sort_by_city}}</td>
                                        <td>{{ auth()->user()->userCost->store_return_shipment}}</td>
                                        <td>{{ auth()->user()->userCost->reprocess_return_shipment}}</td>
                                        @endif

                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        </div>
                        @if (auth()->user()->read_terms == 0)
                        <div class="col-xs-12">
                            <form action="{{route('terms.agree')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="agree" required />
                                        @lang('app.agree_ask')
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">@lang('app.agree_and_save')</button>
                                </div>


                            </form>
                        </div>
                        @else
                        <div class="col-xs-12">
                            <a class="btn btn-info printhidden" href="{{route('client.dashboard')}}"><i
                                    class="fa fa-reply-all"></i> @lang('app.dashboard')</a>
                        </div>
                        @endif

                    </div>
                </div>
                <!-- /.row -->

            </section>
            <!-- /.content -->
            @else
            <section class="content">

                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">

                        <div class="col-xs-12">
                            <hr>
                        </div>
                        <div class="col-xs-12">
                            @if((auth()->user()->work==2))

                            <div class="col-xs-6">

                                {!! auth()->user()->company_setting->term_en_res !!}
                            </div>
                            <div style="text-align: right" class="col-xs-6">
                                {!! auth()->user()->company_setting->term_ar_res !!}
                            </div>
                            @endif
                            @if((auth()->user()->work==3))
                            <div class="col-xs-6">

                                {!! auth()->user()->company_setting->term_en_warehouse !!}
                            </div>
                            <div style="text-align: right" class="col-xs-6">
                                {!! auth()->user()->company_setting->term_ar_warehouse !!}
                            </div>
                            @endif
                        </div><br><br><br>
                        <div class="col-xs-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('admin_message.Delivery Cost')</th>
                                        <th>@lang('admin_message.Additional kilo price')</th>
                                        <th>@lang('admin_message.Kilo number')</th>
                                        <th>@lang('admin_message.fees cost on delivery')</th>
                                        <th>@lang('admin_message.fees cost on reshipping')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ auth()->user()->cost_inside_city}}</td>
                                        <td>{{ auth()->user()->additional_kilo_price}}</td>
                                        <td>{{ auth()->user()->kilos_number}}</td>
                                        <td>{{ auth()->user()->fees_cash_on_delivery}}</td>
                                        <td>{{ auth()->user()->cost_reshipping }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        @if (auth()->user()->read_terms == 0)
                        <div class="col-xs-12">
                            <form action="{{route('terms.agree')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="agree" required />
                                        @lang('app.agree_ask')
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">@lang('app.agree_and_save')</button>
                                </div>


                            </form>
                        </div>
                        @else
                        <div class="col-xs-12">
                            <a class="btn btn-info printhidden" href="{{route('client.dashboard')}}"><i
                                    class="fa fa-reply-all"></i> @lang('app.dashboard')</a>
                        </div>
                        @endif

                    </div>

                </div>
                <!-- /.row -->

            </section>
            <!-- /.content -->
            @endif
        </div>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{asset('assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('assets/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    <!-- page script -->

</body>

</html>