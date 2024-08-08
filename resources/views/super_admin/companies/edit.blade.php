@extends('layouts.master')

@section('pageTitle', 'تعديل الشركة')




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

    @include('layouts._header-form', ['title' => 'الشركة', 'type' => 'تعديل', 'iconClass' => 'fa-store', 'url' =>
    route('companies.index'), 'multiLang' => 'false'])
  

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


            <div class="col-md-10 col-md-offset-1">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#member" data-toggle="tab"><i class="fa fa-id-card"></i> المعلومات
                                الرئيسة
                            </a></li>
                        <li><a href="#bank" data-toggle="tab"><i class="fa-solid fa-money-bill"></i> معلومات البنك</a></li>
                        <li><a href="#costs" data-toggle="tab"><i class="fa-solid fa-money-bill"></i> الحسابات </a></li>
                        <li><a href="#files" data-toggle="tab"><i class="fa fa-bookmark"></i> المرفقات</a>
                    </ul>

                    <form action="{{route('companies.update', $company->id)}}" enctype="multipart/form-data" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-xs-12">

                            <div class="active tab-pane col-xs-12" id="member">
                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label">الأسم  *</label>
                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="full name" value="{{$company->name}}" required>
                                        @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label">اسم الشركة *</label>
                                    <div class="">
                                        <input type="text" name="store_name" class="form-control" id="fullname"
                                            placeholder="store name" value="{{$company->store_name}}" required>
                                        @error('store_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label">البريد الإلكترونى *</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="Email" value="{{$company->email}}" required>
                                        @error('email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الرقم الضريبى</label>

                                    <div class="">
                                        <input value="{{$company->tax_Number}}" type="text" min="0" class="form-control"
                                            name="tax_Number"
                                            placeholder="الرقم الضريبي يتكون من 15 رقم يبدا 3 و ينتهى 3">
                                        @error('tax_Number')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label">الهاتف</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            value="{{$company->phone}}" placeholder="phone">
                                    </div>
                                </div>

                        
                                <h4><i class="fa fa-key"></i> Password Area</h4>
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">الرقم السري *</label>

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

                                <div class="col-xs-12 form-group">
                                    <label for="password-confirm" class="control-label">تأكيد الرقم السري *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">طبيعة العمل</label>                                       
                                    <div style="display: flex;justify-content: space-between;width: 30%">
                                        <div style="display: flex;gap: 10px">
                                            <label for="" class="control-label" style="margin-top: 4px">متجر</label>
                                            <input {{(in_array(1,$works)) ? 'checked' : ''}} type="checkbox" name="work[]" value="1">
                                        </div>
                                        <div style="display: flex;gap: 10px">
                                            <label for="" class="control-label" style="margin-top: 4px">مطعم</label>
                                            <input {{(in_array(2,$works)) ? 'checked' : ''}}
                                             type="checkbox" name="work[]" value="2">
                                        </div>
                                        <div style="display: flex;gap: 10px">
                                            <label for="" class="control-label" style="margin-top: 4px">مستودع</label>
                                            <input {{(in_array(3,$works)) ? 'checked' : ''}} type="checkbox" name="work[]" value="3">
                                        </div>
                                        <div style="display: flex;gap: 10px">
                                            <label for="" class="control-label" style="margin-top: 4px">تعبئة و تغليف</label>
                                            <input {{(in_array(4,$works)) ? 'checked' : ''}} type="checkbox" name="work[]" value="4">
                                        </div>
                                    </div>                                       

                                </div>
                             
                              
                               
                            </div>
                            <!-- /.tab-pane -->

                            <div class=" tab-pane col-xs-12" id="bank">

                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">أسم البنك</label>

                                    <div class="">
                                        <input type="text" name="bank_name" class="form-control" id=""
                                            value="{{$company->bank_name}}" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">رقم الحساب</label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id=""
                                            value="{{$company->bank_account_number}}" placeholder="Account Number">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الأيبان</label>

                                    <div class="">
                                        <input type="text" name="bank_swift" class="form-control" id=""
                                            value="{{$company->bank_swift}}" placeholder="Swift Code">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="costs">
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر اوردر الميل الاخير </label>
                                    <div>
                                        <input type="number" step="any" min="0" class="form-control" name="lastmile_cost"
                                            value="{{$company->companyCost ? $company->companyCost->lastmile_cost : ''}}" placeholder="سعر اوردر الميل الاخير ">
                                        @error('lastmile_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر اوردر المطعم   </label>
                                    <div>
                                        <input type="text" name="food_delivery_cost" class="form-control"
                                            id="" value="{{$company->companyCost ? $company->companyCost->food_delivery_cost : ''}}" placeholder="سعر اوردر المطعم ">
                                        @error('Food_delivery_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر اوردر فلفمينت  </label>
                                    <div>
                                        <input type="number" step="any" min="0" class="form-control" name="fulfillment_cost"
                                            value="{{$company->companyCost ? $company->companyCost->fulfillment_cost : ''}}" placeholder="سعر اوردر فلفمينت ">
                                        @error('fulfillment_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر اشتراك المستودع   </label>
                                    <div>
                                        <input type="number" step="any" min="0" class="form-control" name="warehouse_cost"
                                            value="{{$company->companyCost ? $company->companyCost->warehouse_cost : ''}}" placeholder="سعر اشتراك المستودع ">
                                        @error('warehouse_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر توصيل سله  </label>
                                    <div>
                                        <input type="number" step="any" min="0" class="form-control" name="salla_cost"
                                            value="{{$company->companyCost ? $company->companyCost->salla_cost : ''}}"placeholder="سعر توصيل سله ">
                                        @error('salla_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر توصيل زد    </label>
                                    <div>
                                        <input  value="{{$company->companyCost ? $company->companyCost->zid_cost : ''}}" type="number" step="any" min="0" class="form-control" name="zid_cost"
                                            placeholder="سعر توصيل زد ">
                                        @error('zid_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> سعر توصيل فوديكس  </label>
                                    <div>
                                        <input type="number" step="any" min="0" class="form-control" name="foodics_cost"
                                            value="{{$company->companyCost ? $company->companyCost->foodics_cost : ''}}"placeholder="سعر توصيل فوديكس ">
                                        @error('foodics_cost')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                
                            <div class=" tab-pane col-xs-12" id="files">

                            <div class="col-xs-6 form-group">
                                @if($company->Tax_certificate !=NULL)
                                <a href="{{asset('storage/'.$company->Tax_certificate)}}"><img style="height: 50px;width:50px" src="{{asset('storage/'.$company->Tax_certificate)}}" alt=""></a>


                                @endif
                                
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
                                @if($company->commercial_register !=NULL)
                                <a href="{{asset('storage/'.$company->commercial_register)}}"><img style="height: 50px;width:50px" src="{{asset('storage/'.$company->commercial_register)}}" alt=""></a>


                                @endif
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
                        <div class=" footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                </div>
                </form>

                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
</div>
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
</script>

@endsection