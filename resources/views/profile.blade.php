@extends('layouts.master')
@section('pageTitle', 'Profile')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Profile', 'type' => 'Edit', 'iconClass' => 'fa-user', 'url' => '/'.Auth()->user()->user_type , 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
            <div class="row">
    
                <form action="{{route('profile.update', $user->id)}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-7 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Edit</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
    
                            <div class="box-body">
                                    <div class="form-group">
                                            <label for="firstname" class="control-label">Full Name *</label>
        
                                            <div class="">
                                                <input type="text" name="name" class="form-control" id="fullname"
                                                    placeholder="full name" value="{{$user->name}}" required>
                                                    @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email *</label>
        
                                            <div class="">
                                                <input type="email" name="email" class="form-control" id="inputEmail"
                                                    placeholder="Email" value="{{$user->email}}" required>
                                                    @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="control-label">phone</label>
        
                                            <div class="">
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                value="{{$user->phone}}"  placeholder="phone">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="lastname" class="control-label">City *</label>
                                                <div class="">
                                                    <select class="form-control" name="city_id" required>
                                                        <option value="">@lang('admin_message.Select a city')</option>
                                                        @foreach ($cities as $city)
                                                        <option {{($user->city_id == $city->id)? 'selected' : ''}} value="{{$city->id}}">{{$city->title}}</option>
                                                        @endforeach
            
                                                    </select>
                                                    @error('city_id')
                                                        <span class="invalid-feedback text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        <h4><i class="fa fa-key"></i> Password Area</h4>
                                        <div class="form-group">
                                            <label for="password" class="control-label">password</label>
        
                                            <div class="">
                                                <input type="password" name="password" class="form-control" id="password"
                                                    placeholder="password">
                                                    @error('password')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="password-confirm" class="control-label">Confirm password</label>
        
                                            <div class="">
                                                <input id="password-confirm" type="password" class="form-control"
                                                    placeholder="Confirm password" name="password_confirmation">
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
                                        <img src="{{asset('storage/'.$user->avatar)}}" class="img-circle" alt="User Image"
                                            width="130">
                                    </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">File input</label>
                                        <input name="avatar" type="file" id="exampleInputFile">
    
                                    </div>
                                </div>
                            </div>
    
    
    
                        </div><!-- /.box -->
                    </div>
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form> <!-- /.row -->
        </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection