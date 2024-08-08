@extends('layouts.master')
@section('pageTitle', 'عرض طلب الأنضمام')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'طلب أنضمام الشركات المشغلة ', 'type' => 'Show', 'iconClass' => 'fa-users', 'url' =>
    route('delegate_request_join.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                       

                        <h3 class="profile-username text-center">{{$delegate->name}}</h3>


                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>رقم الجوال</b> <a class="pull-right">{{$delegate->manger_phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>البريد اللإلكترونى</b> <a class="pull-right">{{$delegate->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>المدينة</b> <a class="pull-right">{{$delegate->city ? $delegate->city->title : '' }}</a>
                            </li>
                          
                           <li class="list-group-item">
                                <b>؟ هل مشترك فى هييئة النقل العام </b> <a class="pull-right">
                                    @if($delegate->is_transport == 1)
نعم
                                  

                                    @else
                                      لا
                                    @endif
                                </a>
                            </li>  
                         
                            <li class="list-group-item">
                                <b> عدد الموظفين</b> <a class="pull-right">{{$delegate->num_employees}}</a>
                            </li>  <li class="list-group-item">
                                <b>عدد السيارات</b> <a class="pull-right">{{$delegate->num_cars}}</a>
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