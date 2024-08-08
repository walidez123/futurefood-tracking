@extends('layouts.master')
@section('pageTitle', 'تعديل المشرف')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'المشرف', 'type' => 'تعديل', 'iconClass' => 'fa-users', 'url' =>
    route('supervisor.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
            <div class="row">
    
                <form action="{{route('supervisor.update', $user->id)}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-7 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> تعديل</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
    
                            <div class="box-body">
                                    <div class="form-group">
                                            <label for="firstname" class="control-label">الأسم بالكامل *</label>
        
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
                                            <label for="email" class="control-label">البريد الإلكترونى *</label>
        
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
                                            <label for="phone" class="control-label">رقم الجوال</label>
        
                                            <div class="">
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                value="{{$user->phone}}"  placeholder="phone">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                    <label for="lastname" class="control-label"> أظهار التقرير اليومى</label>
                                    <div class="">
                                        <select  id="" class="form-control " name="show_report" required>
                                        <option {{($user->show_report == 1)? 'selected' : ''}} value="1"> نعم </option>
                                            <option {{($user->show_report == 0)? 'selected' : ''}} value="0"> لا </option>


                                           
                                           

                                        </select>
                                        @error('show_report')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <label for="password" class="control-label"> الشركات المشغلة 
                                    </label>

                                    <div class="">
                                        <select name="service_provider" id="service_provider"
                                            class="form-control select2">
                                            <option value="">أختر الشركات المشغلة  </option>
                                                @foreach ($service_providers as $service_provider)
                                                @if($service_provider->serviceProvider->id==$user->service_provider)
                                                <option selected value="{{$service_provider->serviceProvider->id}}">{{$service_provider->serviceProvider->name}}</option>
                                                @else
                                                <option  value="{{$service_provider->serviceProvider->id}}">{{$service_provider->serviceProvider->name}}</option>


                                                @endif
                                                @endforeach  
                                             </select>

                                        @error('service_provider')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                 
                                        <h4><i class="fa fa-key"></i> الرقم السرى</h4>
                                        <div class="form-group">
                                            <label for="password" class="control-label">الرقم السرى</label>
        
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
                                            <label for="password-confirm" class="control-label">تأكيد الرقم السري</label>
        
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
                                        <label for="exampleInputFile">الصورة الشخصية</label>
                                        <input name="avatar" type="file" id="exampleInputFile">
    
                                    </div>
                                </div>
                            </div>
    
    
    
                        </div><!-- /.box -->
                    </div>
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
            </div>
            </form> <!-- /.row -->
        </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection