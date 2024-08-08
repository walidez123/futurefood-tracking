@extends('layouts.master')
@section('pageTitle', 'Edit delegate')
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
    @include('layouts._header-form', ['title' => 'المندوب', 'type' => 'تعديل', 'iconClass' => 'fa-users', 'url' =>
    route('delegates.index'), 'multiLang' => 'false'])

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

        <form action="{{route('supervisor-delegates.update', $delegate->id)}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="work" value="{{$delegate->work}}">
                <!-- general form elements -->
                <div class="box box-primary" style="padding: 10px;">
                    <div class="box-header with-border">
                        <h3 class="box-title"> معلومات المندوب</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="row">
                        <div class="box-body">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="firstname" class="control-label">الأسم بالكامل *</label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="full name" value="{{$delegate->name}}" required>
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
                                        <input type="email" name="email" value="{{$delegate->email}}" class="form-control" id="inputEmail"
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
                                        <input type="text" name="phone" value="{{$delegate->phone}}" class="form-control" id="phone"
                                            placeholder="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">المدينة *</label>
                                    <div class="">
                                    <select id="city_id" class="form-control select2" name="city_id" required>
                                                        <option value="">@lang('admin_message.Select a city')</option>
                                                        @foreach ($cities as $city)
                                                        <option {{($delegate->city_id == $city->id)? 'selected' : ''}} value="{{$city->id}}">{{$city->title}}</option>
                                                        @endforeach
            
                                                    </select>
                                        @error('city_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                                <label for="lastname" class="control-label">الحى *</label>
                                                <div class="">
                                                    <select  id="region_id" class="form-control select2" name="region_id" >
                                                     @if($region)
                                                     <option selected  value="{{$region->id}}">{{$region->title}}</option>

                                                     
                                                     
                                                     @endif
            
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
                                <h4><i class="fa fa-key"></i> منطقة الرقم السرى</h4>
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
                                <h4 style="visibility: hidden;"> ss </h4>
                                <h4> </h4>


                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">تأكيد الرقم السري *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation" required>
                                    </div>
                                </div>



                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">العملاء *</label>
                                    <div class="">
                                        <select multiple id="" class="form-control select2" name="client[]" required>
                                            <option value="">أختر العملاء </option>
                                            @foreach ($clients as $client)
                                            @if(in_array($client->id,$Delegate_client))
                                            <option selected value="{{$client->id}}">{{$client->store_name}}</option>
                                            @else
                                            <option value="{{$client->id}}">{{$client->store_name}}</option>


                                            @endif
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
                                            <option {{($delegate->show_report == 1)? 'selected' : ''}} value="1"> نعم </option>
                                            <option {{($delegate->show_report == 0)? 'selected' : ''}} value="0"> لا </option>

                                           
                                           

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
                                        <option {{($delegate->work_type == 1)? 'selected' : ''}} value="1">دوام كلى</option>
                                            <option {{($delegate->work_type == 2)? 'selected' : ''}} value="2">دوام جزئي</option>
                                            <option {{($delegate->work_type == 3)? 'selected' : ''}} value="3"> بالطلب</option>


                                        </select>
                                        @error('work_type')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        

                                    </div>
                                    <label for="email" class="control-label"> </label>
                                    @if($delegate->work_type == 3)
                                    <input placeholder="أدخل المبلغ المطلوب للطلب " value="{{$delegate->payment}}" class="" name="payment" type="text" id="payment"  />

                                    @else
                                    <input placeholder="أدخل المبلغ المطلوب للطلب " class="" name="payment" type="text" id="payment" hidden="hidden" />


                                    @endif


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label">رقم الأقامة</label>

                                    <div class="">
                                        <input value="{{$delegate->Residency_number}}" required type="text" name="Residency_number" class="form-control"
                                            id="Residency_number" placeholder="رقم الأقامة">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">نوع المركبة</label>
                                    <div class="">
                                        <input value="{{$delegate->type_vehicle}}" required type="text" name="type_vehicle" class="form-control"
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
                                        <input value="{{$delegate->Num_vehicle}}" type="text" name="Num_vehicle" class="form-control" id="Num_vehicle"
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
                                        <input value="{{$delegate->date}}" type="date" name="date" class="form-control" id="date" required>
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
                                                @if($supervisor->id==$delegate->manger_name)

                                                <option selected value="{{$supervisor->id}}">{{$supervisor->name}}</option>
                                                @else
                                                <option value="{{$supervisor->id}}">{{$supervisor->name}}</option>

                                                @endif
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
                                                @if($service_provider->id==$delegate->service_provider)
                                                <option selected value="{{$service_provider->id}}">{{$service_provider->name}}</option>
                                                @else
                                                <option  value="{{$service_provider->id}}">{{$service_provider->name}}</option>


                                                @endif
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
                                        <input type="text" value="{{$delegate->bank_name}}" name="bank_name" class="form-control" id="bank_name"
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
                                        <input type="text" value="{{$delegate->bank_account_number}}" name="bank_account_number" class="form-control" id="bank_account_number"
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
                        <div class="box-body">

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class=" image">
                                <img src="{{asset('storage/'.$delegate->avatar)}}" class="img-circle" alt="User Image"
                                            width="130">
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
                            <img src="{{asset('storage/'.$delegate->vehicle_photo)}}" class="img-circle" alt="User Image"
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
                        <img src="{{asset('storage/'.$delegate->license_photo)}}" class="img-circle" alt="User Image"
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
                <img src="{{asset('storage/'.$delegate->residence_photo)}}" class="img-circle" alt="User Image"
                                            width="130">                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <label for="exampleInputFile">صوره الإقامة </label>
                    <input name="residence_photo" type="file" id="exampleInputFile">

                </div>
            </div>
        </div>



</div><!-- /.box -->
</div>
</div>

<div class=" footer">
    <input type="hidden" name="user_type" value="delegate">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form> <!-- /.row -->
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