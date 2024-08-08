@extends('layouts.master')
@section('pageTitle', __('user.employee'))
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
<style>
.select2-container {
    width: 100% !important;
}
</style>

@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>  __('user.employee'), 'type' => trans('admin_message.Add'), 'iconClass' => 'fa-users', 'url' =>
    route('employees.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('employees.store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="work_type" value="employee">
                <div class="col-md-7 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__('admin_message.Add')}} {{__('user.employee')}} </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                               
                                <div class="form-group">
                                    <label for="firstname" class="control-label"> {{__('user.Name')}} *</label>
                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="{{__('user.Full Name')}}" required>
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="email" class="control-label">{{__('admin_message.Email')}} *</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="{{__('admin_message.Email')}}" required>
                                        @error('email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">{{__('admin_message.Phone')}}</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="{{__('admin_message.phoneMessage')}}">
                                        @error('phone')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="">
                                
                                <h4><i class="fa fa-key"></i>  {{__('admin_message.password')}} </h4>
                                <div class="form-group">
                                    <label for="password" class="control-label">{{__('admin_message.password')}} *</label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="{{__('admin_message.passwordMassage')}}" required>
                                            @error('password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">{{__('admin_message.confirm password')}} *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation" required>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>
                <div class="col-md-5 text-center">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <div class=" image">
                                    <img src="{{asset('storage/avatar/avatar.png')}}" class="img-circle" alt="User Image"
                                        width="130">
                                </div>
                                <div class="form-group" style="margin-top: 15px;">
                                    <label for="exampleInputFile">{{__('admin_message.personal photo')}}</label>
                                    <input name="avatar" type="file" id="exampleInputFile">
                                    @error('avatar')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        <div class=" footer">
            <input type="hidden" name="user_type" value="employee">
            <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
        </div>
        </form> <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->