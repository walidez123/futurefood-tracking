@extends('layouts.master')
 
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">  
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    <!-- Main content -->
    <section class="content">
<div class="col-md-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="nav-tabs-custom">
                    <form  enctype="multipart/form-data"  action="{{route('companies.setting.edit')}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf
                        <input type="hidden" name="company_id" value="{{$company->id}}">
                        <input type="hidden" name="id" value="{{$setiing->id}}">


                  
                    <ul class="nav nav-tabs" >
                        <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i class="fa fa-shop"></i> بيانات خدمة إرسال الرسائل القصيرة</a></li>
                    </li></ul>
                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="bank">
                              
                            <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label"> أسم المستخدم فى خدمة الرسائل</label>

                                    <div class="">
                                        <input type="text" value="{{$setiing->sms_username}}" name="sms_username" class="form-control" id="sms_username"
                                            placeholder="  " required>
                                            @error('sms_username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label"> أسم المراد إرسال فى الرسائل </label>

                                    <div class="">
                                        <input type="text" value="{{$setiing->sms_sender_name}}" name="sms_sender_name" class="form-control" id="sms_sender_name"
                                            placeholder="  " required>
                                            @error('sms_sender_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                         
                                 <div class="col-xs-12 form-group">
                                    <label for="" class="control-label"> رقم الجوال المسجل فى خدمة الرسائل</label>

                                    <div class="">
                                        <input type="text" min="0" value="{{$setiing->sms_mobile}}" class="form-control" name="sms_mobile"
                                            placeholder="" >
                                            @error('sms_mobile')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>       
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">password * كلمة المرور </label>

                                    <div class="">
                                        <input type="password" value="{{$setiing->sms_password}}" name="sms_password" class="form-control" id="password"
                                            placeholder="sms_password" required>
                                            @error('sms_password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

        
                        </div>
                      
                    </div>
                    <!-- /.tab-content -->
                          <div class=" footer col-lg-12">
                                <button type="submit" class="btn btn-primary">تسجيل</button>
                            </div>
                     </form>
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
 
 
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>

@endsection