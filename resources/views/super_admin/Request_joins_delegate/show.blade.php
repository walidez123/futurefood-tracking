@extends('layouts.master')
@section('pageTitle', 'عرض طلب الأنضمام')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Delegate', 'type' => 'Show', 'iconClass' => 'fa-users', 'url' =>
    route('delegate_request_join.index'), 'multiLang' => 'false'])

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
                                <b>المدينة</b> <a class="pull-right">{{$delegate->city ? $delegate->city->title : " " }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>الحى</b> <a class="pull-right">{{$delegate->neighborhood ? $delegate->neighborhood->title : " " }}</a>
                            </li>
                           <li class="list-group-item">
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
                            </li> </li> 
                           <li class="list-group-item">
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
       

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection