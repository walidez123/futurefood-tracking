@extends('layouts.master')
@section('pageTitle', 'Dashboard')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('app.dashboard')
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ auth()->user()->orders()->count() }}</h3>

                            <p>@lang('app.orders', ['attribute' => ''])</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue ">
                        <div class="inner">
                            <h3>{{ $monthlyOrders->count() }}</h3>

                            <p>{{ __('admin_message.current month orders count') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $deliverdOrders->count() }}</h3>

                            <p>{{ __('admin_message.orders_delivered') }} </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red ">
                        <div class="inner">
                            <h3>{{ $balance == null ? '0' : $balance }}</h3>

                            <p>{{ __('admin_message.wallet') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-money-bill"></i>
                        </div>

                    </div>
                </div>
                @if (Auth()->user()->work==4)
                  <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green ">
                        <div class="inner">
                            <h3>{{ $goods }}</h3>

                            <p>{{ __('admin_message.Goods') }}</p>
                        </div>
                        <div class="icon">
                          <i class="fa-solid fa-store"></i>
                        </div>

                    </div>
                  </div>
               @endif

                <!-- warehouse -->
                @if (Auth()->user()->work == 3)
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue ">
                            <div class="inner">
                                <h3>{{ $packageCount }}</h3>

                                <p> {{ __('admin_message.Packages') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue ">
                            <div class="inner">
                                <h3>{{ $total_area }}</h3>

                                <p>{{ __('admin_message.total area') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red ">
                            <div class="inner">
                                <h3>{{ $packages_area }}</h3>

                                <p>{{ __('admin_message.used area') }}</p>

                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green ">
                            <div class="inner">
                                <h3>{{ $free_area }}</h3>

                                <p>{{ __('admin_message.free area') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>

                        </div>
                    </div>
                    

                @endif

                <!-- end -->
            </div>
            <div class="col-xs-12" style="background: #fff;">

                <ul class="nav nav-tabs"
                    style="
                          background: #fff;
                          font-weight: bold;
                          margin: 15px;
                          margin-bottom: 3px;">
                        <li class="active"><a style="color: #000;
                          padding-right: 25px;" data-toggle="tab"
                                                  href="#menu1">@lang('app.Today')</a></li>
                        <li><a style="color: #000;
                          padding-right: 25px;" data-toggle="tab"
                            href="#menu2">@lang('app.All')</a></li>
                </ul>


                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">

                        <?php $today = (new \Carbon\Carbon())->today(); ?>
                        @foreach ($statuses as $status)
                            <div class="col-sm-4 col-md-2 ">
                                <div class="small-box  bg-gray box_status"
                                    style="    height: 120px !important;padding:10px;height: 150px;">
                                    <div class="icon">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                    <a style="color:#000"
                                        href="{{ url('/client/orders?status_id=' . $status->id . '&&bydate=Today') }}">
                                        <h4 class="text-center">

                                            {{ $status->orders()->where('user_id', Auth()->user()->id)->whereDate('updated_at', $today)->count() }}
                                        </h4>
                                        <p class="text-center">{{ $status->trans('title') }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="menu2" class="tab-pane fade in ">
                        @foreach ($statuses as $status)
                            <div class="col-sm-4 col-md-2 ">
                                <div class="small-box  bg-gray box_status"
                                    style="    height: 120px !important;padding:10px;    height: 150px;">
                                    <div class="icon">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                    <a style="color:#000"
                                        href="{{ url('/client/orders?status_id=' . $status->id . '&&bydate=All') }}">
                                        <h4 class="text-center">
                                            <?php $count = \App\Models\Order::where('work_type', Auth()->user()->work)
                                                ->where('user_id', Auth()->user()->id)
                                                ->where('status_id', $status->id)
                                                ->count(); ?>

                                            {{ $count }}
                                        </h4>
                                        <p class="text-center">{{ $status->trans('title') }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>


            </div>



    </div>


    <!-- /.row -->


    </section>
    <!-- /.content -->
    </div>
@endsection
@section('js')
    {!! $orderChart->script() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endsection
