@extends('layouts.master')
@section('pageTitle', ' أضافة مندوب')
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
        <div class="row">
            
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
                                      
                  
                    <ul class="nav nav-tabs" >
                        <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i class="fa fa-shop"></i>معلومات المندوب</a></li>
                        <li class=""><a href="#setting" data-toggle="tab" aria-expanded="false"><i class="fa fa-usd"></i> بيانات التسجيل</a></li>
                        <li class=""><a href="#statuses" data-toggle="tab" aria-expanded="false"><i class="fa fa-bookmark"></i>الدفع</a></li>
                        . 
                    </li></ul>
        <form action="{{route('delegates.store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" enctype="multipart/form-data">
                @csrf
                <!-- general form elements -->
               <input type="hidden" name="work" value="{{$type}}">
                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="bank">
                                      <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">الأسم بالكامل *</label>

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
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="email" class="control-label">البريد الإلكترونى *</label>

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
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="phone" class="control-label">رقم الجوال</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">المدينة *</label>
                                    <div class="">
                                        <select id="city_id" class="form-control select2" name="city_id" required>
                                            <option value="">أختر المدينة </option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->id}}">{{$city->title}}</option>
                                            @endforeach

                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">الحى *</label>
                                    <div class="">
                                        <select id="region_id" class="form-control select2" name="region_id" required>
                                           

                                        </select>
                                        @error('region_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            
                                <div class="form-group">
                                    <label for="password" class="control-label">الرقم السرى *</label>

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
                            </div>
                            <div class="col-md-6">
                                <h4 style="visibility: hidden;">  </h4>
                                <h4> </h4>


                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">تأكيد الرقم السري *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation" required>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="setting">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname" class="control-label">العملاء</label>
                                        <div class="">
                                            <select multiple id="" class="form-control select2" name="client[]"
                                                >
                                                <option value="">أختر العملاء </option>
                                                @foreach ($clients as $client)
                                                <option value="{{$client->id}}">{{$client->store_name}}</option>
                                                @endforeach

                                            </select>
                                            @error('client')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                         <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label"> أظهار التقرير اليومى</label>
                                    <div class="">
                                        <select  id="" class="form-control " name="show_report" required>
                                            <option  value="1"> نعم </option>
                                            <option  value="0"> لا </option>

                                           
                                           

                                        </select>
                                        @error('show_report')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="control-label">نوع العمل</label>

                                    <div class="">
                                        <select id="work_type" name="work_type" class="form-control select2" required>
                                            <option value="1">دوام كلى</option>
                                            <option value="2">دوام جزئي</option>
                                            <option value="3"> بالطلب</option>

                                        </select>
                                        @error('work_type')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        

                                    </div>
                                    <label for="email" class="control-label"> </label>

                                        <input placeholder="أدخل المبلغ المطلوب للطلب " class="" name="payment" type="text" id="payment" hidden="hidden" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label">رقم الأقامة</label>

                                    <div class="">
                                        <input required type="text" name="Residency_number" class="form-control"
                                            id="Residency_number" placeholder="رقم الأقامة">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">نوع المركبة</label>
                                    <div class="">
                                        <input required type="text" name="type_vehicle" class="form-control"
                                            id="type_vehicle" placeholder=" نوع المركبة">

                                        @error('type_vehicle')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label">رقم لوحه المركبة
                                    </label>

                                    <div class="">
                                        <input type="text" name="Num_vehicle" class="form-control" id="Num_vehicle"
                                            placeholder="رقم لوحة المركبة" required>
                                        @error('Num_vehicle')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label"> تاريخ التعين
                                    </label>

                                    <div class="">
                                        <input type="date" name="date" class="form-control" id="date" required>
                                        @error('date')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="password" class="control-label"> أسم المشرف
                                    </label>

                                    <div class="">
                                        <select name="manger_name" id="manger_name"
                                            class="form-control select2">
                                            <option value=""> أختر المشرف</option>
                                                @foreach ($supervisors as $supervisor)
                                                <option value="{{$supervisor->id}}">{{$supervisor->name}}</option>
                                                @endforeach

                                        </select>

                                        @error('manger_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label"> الشركات المشغلة 
                                    </label>

                                    <div class="">
                                        <select name="service_provider" id="service_provider"
                                            class="form-control select2">
                                            <option value="">أختر الشركات المشغلة  </option>
                                                @foreach ($service_providers as $service_provider)
                                                <option value="{{$service_provider->id}}">{{$service_provider->name}}</option>
                                                @endforeach

                                        </select>

                                        @error('service_provider')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_name" class="control-label"> أسم البنك
                                    </label>

                                    <div class="">
                                        <input type="text" name="bank_name" class="form-control" id="bank_name"
                                            required>
                                        @error('bank_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_account_number" class="control-label">  رقم الحساب البنكى
                                    </label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id="bank_account_number"
                                            required>
                                        @error('bank_account_number')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                       
 
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="statuses">
                               <div class="col-md-6">
                                        <div class="form-group">
                                            <div class=" image">
                                                <img src="{{asset('storage/avatar/avatar.png')}}" class="img-circle"
                                                    alt="User Image" width="130">
                                            </div>
                                            <div class="form-group" style="margin-top: 15px;">
                                                <label for="exampleInputFile">صورة شخصية </label>
                                                <input name="avatar" type="file" id="exampleInputFile">
            
                                            </div>
                                        </div>
                                    </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <div class=" image">
                                            <img src="{{asset('storage/avatar/avatar.png')}}" class="img-circle" alt="User Image"
                                                width="130">
                                        </div>
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label for="exampleInputFile"> صورة المركبة</label>
                                            <input name="vehicle_photo" type="file" id="exampleInputFile">
            
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class=" image">
                                        <img src="{{asset('storage/avatar/avatar.png')}}" class="img-circle" alt="User Image"
                                            width="130">
                                    </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">صورة الرخصة </label>
                                        <input name="license_photo" type="file" id="exampleInputFile">
            
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <div class=" image">
                                <img src="{{asset('storage/avatar/avatar.png')}}" class="img-circle" alt="User Image" width="130">
                            </div>
                            <div class="form-group" style="margin-top: 15px;">
                                <label for="exampleInputFile">صوره الإقامة </label>
                                <input name="residence_photo" type="file" id="exampleInputFile">
            
                            </div>
                        </div>
                    </div>
                            
                       
                       
                          
                        </div>
                        
                        
                        <div class=" footer">
                            <input type="hidden" name="user_type" value="delegate">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                         
                    
                </div>

            </form>
 <!-- /.row -->
</section>

<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.select2').select2()
});
$("#work_type").change(function () {
  var selected_option = $('#work_type').val();

  if (selected_option === '3') {
    $('#payment').attr('pk','1').show();
    $('#payment').addClass('form-control');

  }
  if (selected_option != '3') {
    $("#payment").removeAttr('pk').hide();
  }
})
</script>


@endsection