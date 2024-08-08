@extends('layouts.master')
@section('pageTitle', 'عرض الشركة')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'الشركة', 'type' => 'عرض', 'iconClass' => 'fa-users', 'url' =>
    route('users.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('storage/'.$company->avatar)}}"
                            alt="User profile picture">

                        <h3 class="profile-username text-center">{{$company->name}}</h3>

                        <p class="text-muted text-center">{{$company->user_type}}</p>

                        <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                                <b> نوع الحساب :</b> <a class="pull-right">
                                @if($company->company_active==0)
                                 غير مفعل
                                 @else
                                 مفعل
                                @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>رقم الجوال</b> <a class="pull-right">{{$company->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>البريد الإلكترونى</b> <a class="pull-right">{{$company->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b> الرقم الضريبى</b> <a class="pull-right">{{$company->tax_Number}}</a>
                            </li>
                            <li class="list-group-item">
                                <b> البنك</b> <a class="pull-right">{{$company->bank_name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b> رقم الحساب</b> <a class="pull-right">{{$company->bank_account_number}}</a>
                            </li>
                            <li class="list-group-item">
                                <b> رقم الأيبان</b> <a class="pull-right">{{$company->bank_swift}}</a>
                            </li>

                            @if($company->commercial_register !=NULL)
                            <li class="list-group-item">

                            <p class="lead"><span class="h3"> السجل التجارى:</span><a download="" href="{{asset('storage/'.$company->commercial_register)}}">تحميل</a></p>
                            </li>

                            @endif


                            @if($company->Tax_certificate !=NULL)

                            <li class="list-group-item">

                            <p class="lead"><span class="h3"> الشهادة الضريبة:</span> <a download="" href="{{asset('storage/'.$company->Tax_certificate)}}">تحميل</a> 
                                </p>

                            </li>

                            @endif

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