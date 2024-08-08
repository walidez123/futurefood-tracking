@extends('layouts.master')
@section('pageTitle', 'Show user')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'user', 'type' => 'Show', 'iconClass' => 'fa-users', 'url' =>
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

                        <p class="text-muted text-center">{{$user->role->title}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Phone</b> <a class="pull-right">{{$user->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{$user->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Role</b> <a class="pull-right">{{$user->role->title}}</a>
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