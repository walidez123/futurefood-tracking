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
                                        <form  enctype="multipart/form-data"  action="{{route('companies.store')}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf

                  
                    <ul class="nav nav-tabs" >
                        <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i class="fa fa-shop"></i>بيانات العميل</a></li>
                        <li class=""><a href="#statuses" data-toggle="tab" aria-expanded="false"><i class="fa fa-bookmark"></i>الدفع</a></li>
                        <li><a href="#provider" data-toggle="tab"><i class="fa fa-bookmark"></i> المرفقات</a>
                    </li></ul>
                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="bank">
                              
                                          <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label">  * اسم  </label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="أدخل أسم المدير" required>
                                            @error('name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                
                                 <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الرقم الضريبى</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="tax_Number"
                                            placeholder="الرقم الضريبي يتكون من 15 رقم يبدا 3 و ينتهى 3" >
                                            @error('tax_Number')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                             
                             
                             
                      
                             <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label"> رقم الجوال</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="phone">
                                    </div>
                                </div>
                                     <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label"> * البريد الالكتروني</label>

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
                                    
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">password * كلمة المرور </label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="password" required>
                                            @error('password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="password-confirm" class="control-label"> * تاكيد كلمه المرور </label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation" required>
                                    </div>
                                </div>
                                 <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">طبيعة العمل</label>

                                    <div class="">
                                        <select name="work" class="form-control" id="">
                                            <option  value="1">متجر</option>
                                            <option  value="2">مطعم</option>
                                            <option  value="3">مطعم و متجر معا</option>
                                        </select>
                                       
                                    </div>
                                </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="statuses">

                               
                                    
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> أسم البنك</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="bank_name"
                                            placeholder="Enter the name of bank" >
                                            @error('bank_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label">رقم الحساب</label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id=""
                                        value=""  placeholder="Account Number">
                                        @error('bank_account_number')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> ايبان</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="bank_swift"
                                            placeholder="Enter the bank swift code" >
                                            @error('bank_swift')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                       
                          
                        </div>
                       
                        <div class="tab-pane" id="provider">
                                   <div class="col-xs-6 form-group">
                                    <label for="Tax_certificate" class="control-label">   الشهادة الضريبة </label>
                                    <div class="">
                                        <input type="file" name="Tax_certificate" id="">
                                       
                                        @error('Tax_certificate')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-6 form-group">
                                    <label for="commercial_register" class="control-label">    السجل التجارى </label>
                                    <div class="">
                                        <input type="file" name="commercial_register" id="">
                                       
                                        @error('commercial_register')
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