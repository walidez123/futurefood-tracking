@extends('layouts.master')
@section('pageTitle', trans('user.add_supervisor'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => trans('user.supervisor'), 'type' => 'Add', 'iconClass' => 'fa-users', 'url' =>
    route('supervisor.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('supervisor.store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" enctype="multipart/form-data">
                @csrf
                <div class="col-md-7 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> @lang('user.Add')</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                                <div class="form-group">
                                        <label for="firstname" class="control-label"> @lang('user.Full Name') *</label>
    
                                        <div class="">
                                            <input type="text" name="name" class="form-control" id="fullname"
                                                placeholder="full name" required>
                                                @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="email" class="control-label">@lang('user.Email')  *</label>
    
                                        <div class="">
                                            <input type="email" name="email" class="form-control" id="inputEmail"
                                                placeholder="Email" required>
                                                @error('email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label"> @lang('user.Phone')</label>
    
                                        <div class="">
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                placeholder="phone">
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label for="lastname" class="control-label"> @lang('user.show_daily_report')</label>
                                    <div class="">
                                        <select  id="" class="form-control " name="show_report" required>
                                            <option  value="1"> @lang('user.yes') </option>
                                            <option  value="0"> @lang('user.no') </option>

                                           
                                           

                                        </select>
                                        @error('show_report')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">@lang('user.Service provider') 
                                    </label>

                                    <div class="">
                                        <select name="service_provider" id="service_provider"
                                            class="form-control select2">
                                            <option value="">  @lang('user.Select service provider') </option>
                                                @foreach ($service_providers as $service_provider)
                                                <option value="{{$service_provider->serviceProvider->id}}">{{$service_provider->serviceProvider->name}}</option>
                                                @endforeach

                                        </select>

                                        @error('service_provider')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                    <h4><i class="fa fa-key"></i> @lang('user.password') </h4>
                                    <div class="form-group">
                                        <label for="password" class="control-label">@lang('user.password') *</label>
    
                                        <div class="">
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="@lang('user.password')" required>
                                                @error('password')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="password-confirm" class="control-label">  @lang('user.Confirm password') *</label>
    
                                        <div class="">
                                            <input id="password-confirm" type="password" class="form-control"
                                                placeholder="@lang('user.Confirm password')" name="password_confirmation" required>
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
                                    <label for="exampleInputFile">@lang('user.Avatar')  </label>
                                    <input name="avatar" type="file" id="exampleInputFile">

                                </div>
                            </div>
                        </div>



                    </div><!-- /.box -->
                </div>
        </div>
        <div class=" footer">
            <input type="hidden" name="user_type" value="supervisor">
            <button type="submit" class="btn btn-primary">@lang('user.add')</button>
        </div>
        </form> <!-- /.row -->
    </section>

    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection