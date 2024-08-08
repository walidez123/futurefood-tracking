@extends('layouts.master')
@section('pageTitle', __('admin_message.Service provider'))
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
    @include('layouts._header-form', ['title' =>  __('admin_message.Service provider'), 'type' => trans('admin_message.Add'), 'iconClass' => 'fa-users', 'url' =>
    route('service_provider.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('service_provider.store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" enctype="multipart/form-data">
                @csrf
                <div class="col-md-7 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__('admin_message.Add')}} {{__('admin_message.Service provider')}} </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                                <div class="form-group">
                                    <label for="work">{{ __('admin_message.work type') }}<span>*</span></label>
                                    <select multiple name="works[]" class="form-control service_provider_cost_type select2" required>
                                        <option value="">{{ __('admin_message.select_work_type') }}</option>
                                        <option value="1">{{ __('admin_message.Clients') }}</option>
                                        <option value="2">{{ __('admin_message.restaurants') }}</option>
                                        <option value="4">{{ __('fulfillment.fulfillment') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                        <label for="firstname" class="control-label"> {{__('admin_message.company_name')}} *</label>
    
                                        <div class="">
                                            <input type="text" name="name" class="form-control" id="fullname"
                                                placeholder="{{__('admin_message.company_name')}}" required>
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
                                    <div class="form-group">
                                    <label for="lastname" class="control-label">{{__('admin_message.Show External Reports')}}</label>
                                    <div class="">
                                        <select  id="" class="form-control " name="show_report" required>
                                            <option  value="1"> {{__('admin_message.Yes')}} </option>
                                            <option  value="0"> {{__('admin_message.No')}} </option>
                                        </select>
                                        @error('show_report')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    </div>
                                    <!-- Accounting -->
                                    <div style="display: none;"  class="form-group Accounting_service_provider_1">
                                        <label for="accounting_last_mile" class="control-label">{{__('admin_message.accounting_last_mile')}}</label>
    
                                        <div class="">
                                            <input type="number" step="any" value="0" name="cost_last_mile" class="form-control" id=""
                                                placeholder="">
                                                @error('cost_last_mile')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div style="display: none;"  class="form-group Accounting_service_provider_2">
                                        <label for="accounting_restaurant" class="control-label">{{__('admin_message.accounting_restaurant')}}</label>
    
                                        <div class="">
                                            <input type="number" step="any" value="0" name="cost_restaurant" class="form-control" id=""
                                                placeholder="">
                                                @error('cost_restaurant')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div style="display: none;"  class="form-group Accounting_service_provider_4">
                                        <label for="accounting_fulfillment" class="control-label">{{__('admin_message.accounting_fulfillment')}}</label>
    
                                        <div class="">
                                            <input type="number" step="any" value="0" name="cost_fulfillment" class="form-control" id=""
                                                placeholder="">
                                                @error('cost_fulfillment')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        </div>
                                    </div>


                                    <!-- End Accounting -->
                                
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
            <input type="hidden" name="user_type" value="service_provider">
            <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
        </div>
        </form> <!-- /.row -->
    </section>

    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

    <script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

@endsection
