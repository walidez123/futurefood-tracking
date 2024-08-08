<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $appSetting->name }} | @yield('pageTitle')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- delete -->
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" />
    @yield('css')
    <!-- Theme style -->
    @if ($lang == 'ar')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/app.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/rtl.css
        ') }}">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/rtl/adminlte.min.js') }}">
    @else
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.js
        ') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/app.js') }}">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.js') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <style>
        .box-body {
            overflow-x: scroll !important;
        }

        @media print {

            .main-footer {
                display: none;
            }
        }

        .bgs-yellow {
            display: inline-block;
            width: 20px;
            /* Adjust width as needed */
            height: 20px;
            /* Adjust height as needed */
            
            border: 1px solid #ccc;
            /* Optional: Add border */
        }
    </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="/{{ Auth()->user()->user_type }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                {{-- <span class="logo-mini"><b><img src="{{ asset('assets/dist/img/loo.jpeg') }}" width="130" /></b></span>
                 --}}

                @if(Auth()->user()->user_type == 'super_admin')
                    <span class="logo-lg"><b><img src="{{ asset('assets/dist/img/loo.jpeg') }}" width="130" /></b></span>


                @else
                <?php $user = App\Models\Company_setting::where('company_id', Auth()->user()->company_id)->first(); ?>
                    <span class="logo-mini"><b><img src="{{ asset('storage/' . $user->logo) }}" width="130" /></b></span>
                    <span class="logo-lg"><b><img src="{{ asset('storage/' . $user->logo) }}" width="130" /></b></span>
                @endif

                <!-- logo for regular state and mobile devices -->

                {{-- <span class="logo-lg"><b><img src="{{ asset('assets/dist/img/loo.jpeg') }}" width="130" /></b></span> --}}
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if (Auth()->user()->user_type == 'client' ||
                        Auth()->user()->user_type == 'delegate' ||
                        Auth()->user()->user_type == 'admin' ||
                        Auth()->user()->user_type == 'service_provider')
                        @if ($lang == 'ar')
                        <li>
                            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', null, [], true) }}" title=""><i
                                    class="fa fa-language" aria-hidden="true"></i> English</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" title=""><i
                                    class="fa fa-language" aria-hidden="true"></i> العربية </a>
                        </li>
                        @endif
                        @endif
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                @if ($notificationsBar->count() > 0)
                                <span class="label label-warning">{{ $notificationsBar->count() }}</span>
                                @endif

                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">@lang('app.notifications', ['attribute' =>
                                    $notificationsBar->count()]) </li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        @forelse ($notificationsBar as $notification)
                                        <li>
                                            <a href="{{ route('notifications.show', $notification->id) }}">
                                                <i class="fa {{ $notification->icon }} text-aqua"></i>
                                                {{ str_limit($notification->title, '30') }}
                                            </a>
                                        </li>
                                        @empty
                                        <center>
                                            <i class="fa fa-bell"></i>
                                            <h5>@lang('app.notifications', ['attribute' => __('app.no_have')])</h5>
                                        </center>
                                        @endforelse


                                    </ul>
                                </li>
                                <li class="footer"><a
                                        href="{{ route('notifications.index') }}?unread">@lang('app.view')</a></li>
                            </ul>
                        </li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <!--  -->
                          



                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(Auth()->user()->avatar==NULL || Auth()->user()->avatar=='avatar/avatar.png' )
                            <img src="{{ asset('storage/' . $webSetting->logo) }}" class="user-image"
                                    alt="User Image">

                           @else
                                <img src="{{ asset('storage/' . Auth()->user()->avatar) }}" class="user-image"
                                    alt="User Image">
                            @endif
                                <!--  -->
                                <span class="hidden-xs">{{ Auth()->user()->name }} </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                @if(Auth()->user()->avatar==NULL || Auth()->user()->avatar=='avatar/avatar.png' )

                                    <img src="{{ asset('storage/' . $webSetting->logo) }}" class="img-circle"
                                        alt="User Image">
                                @else
                                <img src="{{ asset('storage/' . Auth()->user()->avatar) }}" class="img-circle"
                                        alt="User Image">

                                @endif

                                    <p>
                                        {{ Auth()->user()->name }}
                                        <small>{{ Auth()->user()->user_type }}</small>
                                    </p>
                                </li>
                              
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('profile.edit') }}"
                                            class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Sign
                                            out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @yield('nav')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        <footer class="main-footer">


        </footer>
        <!-- jQuery 3 -->
        <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>

        <!-- Sparkline -->
        <script src="{{ asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

        <!-- SlimScroll -->
        <script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- AdminLTE App -->


        <script
            src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
            type="text/javascript"></script>
        <!--  -->
        <script>
         window.App = {!! json_encode([
          'locale' => app()->getLocale(),
           ]) !!};
       </script>

        <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
        <script src="{{ asset('assets_web/js/custom.js') }}"></script>
        <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>

        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>


        <!--  -->
        @yield('js')
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js">
        </script>
        
        <script>
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}"

                switch (type) {
                    case 'info':
                        toastr.info("{!! Session::get('message') !!}");
                        break;
                    case 'success':
                        toastr.success("{!! Session::get('message') !!}");
                        break;
                    case 'warning':
                        toastr.warning("{!! Session::get('message') !!}");
                        break;
                    case 'error':
                        toastr.error("{!! Session::get('message') !!}");
                        break;
                }
            @endif
        </script>    
</body>

</html>