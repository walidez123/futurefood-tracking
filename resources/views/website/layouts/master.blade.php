<!Doctype html>
<html class="no-js" lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $webSetting->Trans('title') }} | @yield('pageTitle')</title>
    <meta name="description" content="Future Express">
    <meta name="author" content="Themexriver">
    <link rel="shortcut icon" href=" {{ asset('assets_web/img/logo/f-icon.png') }}" type="image/x-icon">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->



    @if ($lang == 'ar')
        <link rel="stylesheet" href="{{ asset('assets_web/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_web/css/style.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets_web/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets_web/css/style_en.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets_web/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/flaticon_aina.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_web/css/magnific-popup.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11468598097"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-11468598097');
    </script>
</head>

<body>
    <div id="preloader"></div>
    <div class="cursor"></div>
    <!-- mobile-menu-start -->


    <div class="offcanvas-overlay"></div>
    <!-- mobile-menu-end -->

    <!-- header-start -->



    <!-- Start of header section
 ============================================= -->
    <header id="bi-header" class="bi-header-section header-style-three">
        <div class="container-fuild">
            <div class="bi-header-content d-flex justify-content-between align-items-center">
                <div class="brand-logo">
                    <a href="#"><img src="{{ asset('storage/' . $webSetting->logo) }}" alt=""></a>
                </div>
                <div class="bi-header-main-navigation">
                    <nav class="main-navigation clearfix ul-li">
                        <ul id="main-nav" class="nav navbar-nav clearfix">

                            <li class="active">
                                <a href="{{ url('/') }}" title="">@lang('website.home')</a>
                            </li>

                            <li>
                                <a href="{{ url('/service') }}" title="">@lang('website.services')</a>
                            </li>

                            <li>
                                <a href="{{ route('join') }}" title="">@lang('website.request_join')</a>
                            </li>

                            <li>
                                <a href="{{ route('contact') }}" title="">@lang('website.contact_us')</a>
                            </li>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" title="">@lang('website.login')</a>
                            </li>
                            @if ($lang == 'ar')
                                <li>
                                    <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                                        title=""><i class="fa fa-language" aria-hidden="true"></i> English</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                                        title=""><i class="fa fa-language" aria-hidden="true"></i> العربية </a>
                                </li>
                            @endif

                        </ul><!-- /.menu -->








                    </nav>
                </div>

            </div>
            <div class="mobile_menu position-relative">
                <div class="mobile_menu_button open_mobile_menu">
                    <i class="fal fa-bars"></i>
                </div>
                <div class="mobile_menu_wrap">
                    <div class="mobile_menu_overlay open_mobile_menu"></div>
                    <div class="mobile_menu_content">
                        <div class="mobile_menu_close open_mobile_menu">
                            <i class="fal fa-times"></i>
                        </div>
                        <div class="m-brand-logo">
                            <a href="!#"><img src="{{ asset('storage/' . $webSetting->logo) }}" alt=""></a>
                        </div>

                        <nav class="mobile-main-navigation  clearfix ul-li">

                            <ul id="m-main-nav" class="nav navbar-nav clearfix">
                                <li class="active">
                                    <a href="{{ url('/') }}" title="">@lang('website.home')</a>
                                </li>

                                <li>
                                    <a href="{{ url('/service') }}" title="">@lang('website.services')</a>
                                </li>

                                <li>
                                    <a href="{{ route('join') }}" title="">@lang('website.request_join')</a>
                                </li>

                                <li>
                                    <a href="{{ route('contact') }}" title="">@lang('website.contact_us')</a>
                                </li>
                                </li>
                                <li>
                                    <a href="{{ route('login') }}" title="">@lang('website.login')</a>
                                </li>
                                @if ($lang == 'ar')
                                    <li>
                                        <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                                            title=""><i class="fa fa-language" aria-hidden="true"></i> English</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                                            title=""><i class="fa fa-language" aria-hidden="true"></i> العربية
                                        </a>
                                    </li>
                                @endif

                            </ul><!-- /.menu -->
                        </nav>

                    </div>
                </div>
                <!-- /Mobile-Menu -->
            </div>
        </div>
    </header>
    @yield('content')


    <!-- Start of Footer  section
 ============================================= -->
    <footer id="bi-footer" class="bi-footer-section">

        <div class="bi-footer-widget-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="bi-footer-widget headline pera-content ul-li-block">
                            <div class="about-widget">
                                <a href="#"><img
                                        src="{{ asset('assets_web/img/new_home/logo/logo-white.png') }}"
                                        alt=""></a>
                                <p> {{ $webSetting->Trans('description') }}</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="bi-footer-widget headline pera-content ul-li-block">
                            <div class="menu-widget">
                                <h3 class="widget-title">@lang('website.helper_links')</h3>
                                <ul>
                                    <li class="active">
                                        <a href="{{ url('/') }}" title="">@lang('website.home')</a>
                                    </li>

                                    <li>
                                        <a href="{{ url('/service') }}" title="">@lang('website.services')</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('join') }}" title="">@lang('website.request_join')</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('contact') }}" title="">@lang('website.contact_us')</a>
                                    </li>
                                    </li>
                                    <li>
                                        <a href="{{ route('login') }}" title="">@lang('website.login')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="bi-footer-widget headline pera-content ul-li-block">
                            <div class="menu-widget">
                                <h3 class="widget-title">@lang('website.contact_information')</h3>
                                <ul>
                                    <li><strong>@lang('website.address'): </strong>{{ $webSetting->Trans('address') }}</li>
                                    <li><strong>@lang('website.email') : </strong>{{ $webSetting->email }}</li>
                                    <li><strong>@lang('website.phone') : </strong>{{ $webSetting->phone }}</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bi-footer-social">
            <div class="container">
                <div class="bi-footer-social-content ul-li">
                    <ul>

                        <li><a href="{{ $webSetting->linked_in }}"><i class="fab fa-linkedin-in"></i> Linked In </a>
                        </li>
                        <li><a href="{{ $webSetting->facebook }}"><i class="fab fa-facebook-f"></i> Facebook </a>
                        </li>
                        <li><a href="{{ $webSetting->instgram }}"><i class="fab fa-instagram"></i> Instagram </a>
                        </li>
                        <li><a href="{{ $webSetting->youtube }}"><i class="fab fa-youtube"></i> Youtube </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="hpt-footer-copyright text-center">
            Copyright 2023 @Future Express
        </div>
    </footer>
    <!-- End of Footer  section
 ============================================= -->




















    <div class="scroll-top">
        <div class="scroll-top-wrap">
            <i class="icon-1 fal fa-long-arrow-up"></i>
            <i class="fal icon-2 fa-spinner fa-pulse"></i>
        </div>
    </div>


    <!-- JS here -->

    <script src="{{ asset('assets_web/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/parallax.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/knob.js') }}"></script>
    <script src="{{ asset('assets_web/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/counter.js') }}"></script>
    <script src="{{ asset('assets_web/js/appear.js') }}"></script>
    <script src="{{ asset('assets_web/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/ScrollSmoother.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/jquery.filterizr.js') }}"></script>
    <script src="{{ asset('assets_web/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/hover-revel.js') }}"></script>
    <script src="{{ asset('assets_web/js/split-type.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('assets_web/js/jquery.marquee.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/tilt.jquery.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/matter.min.js') }}"></script>
    <script src="{{ asset('assets_web/js/script.js') }}"></script>
    <script src="{{ asset('assets_web/js/home-6.js') }}"></script>

</body>

</html>
