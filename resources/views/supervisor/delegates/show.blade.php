@extends('layouts.master')
@section('pageTitle', 'Show Delegate')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Delegate', 'type' => 'Show', 'iconClass' => 'fa-users', 'url' =>
    route('delegates.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('storage/'.$delegate->avatar)}}"
                            alt="User profile picture">

                        <h3 class="profile-username text-center">{{$delegate->name}}</h3>

                        <p class="text-muted text-center">{{$delegate->user_type}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>رقم الجوال</b> <a class="pull-right">{{$delegate->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>البريد اللإلكترونى</b> <a class="pull-right">{{$delegate->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>المدينة</b> <a class="pull-right">{{$delegate->city->title}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>طبيعة العمل </b> <a class="pull-right">
                                {{($delegate->work == 1)? 'طرود' : 'طلبات'}}
                                </a>
                            </li>  <li class="list-group-item">
                                <b>نوع العمل </b> <a class="pull-right">
                                    @if($delegate->work_type == 1)
                                    دوام كلى

                                    @elseif($delegate->work_type == 2)
                                     دوام جزئى

                                    @else
                                      بالقطعة
                                    @endif
                                </a>
                            </li>  
                            @if($delegate->work_type == 3)
                            <li class="list-group-item">
                                <b>مبلغ المطلوب للقطعة</b> <a class="pull-right">{{$delegate->payment}}</a>
                            </li>  
                            @endif
                            <li class="list-group-item">
                                <b>رقم الإقامة</b> <a class="pull-right">{{$delegate->Residency_number}}</a>
                            </li>  <li class="list-group-item">
                                <b>نوع المركبة</b> <a class="pull-right">{{$delegate->type_vehicle}}</a>
                            </li>
                            </li>  <li class="list-group-item">
                                <b>رقم لوحة المركبة</b> <a class="pull-right">{{$delegate->Num_vehicle}}</a>
                            </li> </li>  <li class="list-group-item">
                                <b> تاريخ التعين</b> <a class="pull-right">{{$delegate->date}}</a>
                            </li> </li>  <li class="list-group-item">
                                <b>أسم المشرف</b> <a class="pull-right">{{$delegate->manger_name}}</a>
                            </li> </li>  <li class="list-group-item">
                                <b> الشركات المشغلة </b> <a class="pull-right">{{$delegate->service_provider}}</a>
                            </li> </li>  <li class="list-group-item">
                                <b> صورة المركبة</b> <a download="{{asset('storage/'.$delegate->vehicle_photo)}}" class="pull-right">
                                <img src="{{asset('storage/'.$delegate->vehicle_photo)}}" class="img-circle" alt="User Image"
                                            width="50" height="50">
                                </a>
                            </li>
                            <b> صورة الرخصة</b> <a download="{{asset('storage/'.$delegate->license_photo)}}" class="pull-right">
                            <img src="{{asset('storage/'.$delegate->license_photo)}}" class="img-circle" alt="User Image"
                                            width="50" height="50">
                                </a>
                            </li>
                           
                            
                            </li> </li>  <li class="list-group-item">
                                <b> صورة الأقامة</b> <a download="{{asset('storage/'.$delegate->residence_photo)}}" class="pull-right">
                            <img src="{{asset('storage/'.$delegate->residence_photo)}}" class="img-circle" alt="User Image"
                                            width="50" height="50">
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <ul class="nav nav-pills nav-stacked col-md-3 bg-gray">

                    <li class="active"><a data-toggle="tab" href="#menu1">All</a></li>
                    <li><a data-toggle="tab"  href="#menu2">Today</a></li>
                    <li><a data-toggle="tab"  href="#menu3">Yesterday</a></li>
                    <li><a data-toggle="tab"  href="#menu4">Last Month</a></li>
                </ul>


                <div class="tab-content col-md-9">
                    <div id="menu1" class="tab-pane fade in active">
                        @foreach($statuses as $status)
                            <div class="col-sm-6 col-md-6 ">
                                <div class="small-box  bg-gray" style="padding:10px; background-color: {{$status->color}} !important;">
                                    <h4 class="text-center" >

                                        {{$status->orders()->where('delegate_id', $delegate->id)->count()}}
                                    </h4>
                                    <p class="text-center" >{{$status->title}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="menu2" class="tab-pane fade in">
                        <?php $today = (new \Carbon\Carbon)->today(); ?>
                        @foreach($statuses as $status)
                            <div class="col-sm-6 col-md-6 ">
                                <div class="small-box  bg-gray" style="padding:10px; background-color: {{$status->color}} !important;">
                                    <h4 class="text-center" >

                                        {{$status->orders()->whereDate('created_at', $today)->where('delegate_id', $delegate->id)->count()}}
                                    </h4>
                                    <p class="text-center" >{{$status->title}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="menu3" class="tab-pane fade in">
                        <?php $yesterday = (new \Carbon\Carbon)->yesterday(); ?>
                        @foreach($statuses as $status)
                            <div class="col-sm-6 col-md-6 ">
                                <div class="small-box  bg-gray" style="padding:10px; background-color: {{$status->color}} !important;">
                                    <h4 class="text-center" >

                                        {{$status->orders()->whereDate('created_at', $yesterday)->where('delegate_id', $delegate->id)->count()}}
                                    </h4>
                                    <p class="text-center" >{{$status->title}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="menu4" class="tab-pane fade in">
                        <?php $month = (new \Carbon\Carbon)->subMonth()->submonths(1); ?>
                        @foreach($statuses as $status)
                            <div class="col-sm-6 col-md-6 ">
                                <div class="small-box  bg-gray" style="padding:10px; background-color: {{$status->color}} !important;">
                                    <h4 class="text-center" >

                                        {{$status->orders()->whereDate('created_at', '>', $month)->where('delegate_id', $delegate->id)->count()}}
                                    </h4>
                                    <p class="text-center" >{{$status->title}}</p>
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
</div><!-- /.content-wrapper -->
@endsection
