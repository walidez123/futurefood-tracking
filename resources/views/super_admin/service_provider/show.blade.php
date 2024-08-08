@extends('layouts.master')
@section('pageTitle', 'عرض تفاصيل المشرف')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'مزودين الخدمة', 'type' => 'عرض', 'iconClass' => 'fa-users', 'url' =>
    route('users.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('storage/'.$user->avatar)}}"
                            alt="User profile picture">

                        <h3 class="profile-username text-center">{{$user->name}}</h3>

                        <p class="text-muted text-center">الشركات المشغلة </p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Phone</b> <a class="pull-right">{{$user->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{$user->email}}</a>
                            </li>
                            <!-- <li class="list-group-item">
                                <b>Role</b> <a class="pull-right">hg</a>
                            </li> -->
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