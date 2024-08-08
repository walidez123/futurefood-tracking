@extends('layouts.master')
@section('pageTitle',__('admin_message.Edit Delegete'))
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


                <ul class="nav nav-tabs">
                    <li class="active"><a href="#Main" data-toggle="tab" aria-expanded="true"><i
                                class="fa fa-shop"></i>{{__("admin_message.Main information")}}</a></li>
                    <li class=""><a href="#Registration" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-shop"></i>{{__("admin_message.Registration data")}}</a></li>
                    <li class=""><a href="#JobData" data-toggle="tab" aria-expanded="false"><i class="fa fa-shop"></i>
                            {{__("admin_message.Job data")}}</a></li>
                    <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-bookmark"></i>{{__("admin_message.Official documents")}}</a></li>
                    .
                    </li>
                </ul>
                <form action="{{route('s_p_delegates.update', $delegate->id)}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- general form elements -->
                    <input type="hidden" name="work" value="{{$delegate->work}}">
                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="Main">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname"
                                        class="control-label">{{__("admin_message.Functional code")}}*</label>

                                    <div class="">
                                        <input type="text" value="{{$delegate->code}}" name="code" class="form-control"
                                            id="fullname" placeholder="{{__('admin_message.Functional code')}}"
                                            required>
                                        @error('code')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"
                                        class="control-label">{{__("admin_message.Residency_number")}}</label>

                                    <div class="">
                                        <input value="{{$delegate->Residency_number}}" type="number"
                                            name="Residency_number" class="form-control" id="Residency_number"
                                            placeholder="{{__('admin_message.Residency_number')}}">
                                        @error('Residency_number')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname"
                                        class="control-label">{{__('admin_message.Full Name')}}*</label>
                                    <div class="">
                                        <input value="{{$delegate->name}}" type="text" name="name" class="form-control"
                                            id="fullname" placeholder="{{__('admin_message.Full Name')}}" required>
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
                                    <label for="lastname" class="control-label">{{__('admin_message.City')}} *</label>
                                    <div class="">
                                        <select id="city_id" class="form-control select2" name="city_id" required>
                                            <option value="">{{__('admin_message.Select city')}}</option>
                                            @foreach ($cities as $city)
                                            <option {{($delegate->city_id == $city->id)? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
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
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label for="lastname"
                                        class="control-label">{{__('admin_message.neighborhood')}}</label>
                                    <div class="">
                                        <select id="neighborhood_id" class="form-control select2" name="region_id">
                                        @if($region)
                                                     <option selected  value="{{$region->id}}">{{$region->title}}</option>

                                                     
                                                     
                                                     @endif
                                        </select>
                                        @error('neighborhood')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="Registration">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="phone" class="control-label">{{__('admin_message.Phone')}}*</label>

                                    <div class="">
                                        <input value="{{$delegate->phone}}" required type="text" name="phone" required
                                            class="form-control" id="phone"
                                            placeholder="{{__('admin_message.phoneMessage')}}">
                                        @error('phone')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="email" class="control-label"> {{__('admin_message.Email')}} </label>

                                    <div class="">
                                        <input value="{{$delegate->email}}" type="email" name="email" class="form-control"
                                            id="inputEmail" placeholder="{{__('admin_message.Email')}}">
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
                                    <label for="password"
                                        class="control-label">{{__('admin_message.password')}}*</label>

                                    <div class="">
                                        <input  type="password" name="password"
                                            class="form-control" id=""
                                            placeholder="{{__('admin_message.passwordMassage')}}" >
                                        @error('password')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 style="visibility: hidden;"> </h4>
                                <h4> </h4>


                                <div class="form-group">
                                    <label for="password-confirm"
                                        class="control-label">{{__('admin_message.confirm password')}} *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="{{__('admin_message.confirm password')}}"
                                            name="password_confirmation" >
                                    </div>
                                </div>



                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="JobData">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label"> {{__('admin_message.Supervisor')}}
                                    </label>

                                    <div class="">
                                        <select multiple name="manger_name[]" id="manger_name"
                                            class="form-control select2">
                                            <option value="">{{__('admin_message.Select')}}
                                                {{__('admin_message.Supervisor')}}</option>
                                                @foreach ($supervisors as $supervisor)
                                                @if(in_array($supervisor->id,$Delegate_Mangers))
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
                                    <label for="password" class="control-label">{{__('admin_message.Service provider')}}
                                    </label>

                                    <div class="">
                                        <select name="service_provider" id="service_provider"
                                            class="form-control select2">
                                            <option value="">{{__('admin_message.Select')}}
                                                {{__('admin_message.Service provider')}} </option>
                                            @foreach ($service_providers as $service_provider)
                                            <option {{($delegate->service_provider == $service_provider->id)? 'selected' : ''}} value="{{$service_provider->id}}">{{$service_provider->name}}
                                            </option>
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
                                    <label for="lastname" class="control-label">{{__('admin_message.Clients')}}</label>
                                    <div class="">
                                        <select multiple id="" class="form-control select2" name="client[]">
                                            <option value="">{{__('admin_message.Select')}}
                                                {{__('admin_message.Client')}} </option>
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
                                    <label for="lastname"
                                        class="control-label">{{__('admin_message.Show External Reports')}}</label>
                                    <div class="">
                                        <select id="" class="form-control " name="show_report" >
                                            <option {{($delegate->show_report == 1)? 'selected' : ''}} value="1"> {{__('admin_message.Yes')}} </option>
                                            <option {{($delegate->show_report == 0)? 'selected' : ''}} value="0"> {{__('admin_message.No')}} </option>




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
                                    <label for="email" class="control-label">{{__('admin_message.work type')}}</label>

                                    <div class="">
                                        <select id="work_type" name="work_type" class="form-control select2" required>
                                            <option {{($delegate->work_type == 1)? 'selected' : ''}} value="1">{{__('admin_message.Full time')}}</option>
                                            <option {{($delegate->work_type == 2)? 'selected' : ''}} value="2">{{__('admin_message.Part time')}}</option>
                                            <option {{($delegate->work_type == 3)? 'selected' : ''}} value="3"> {{__('admin_message.By Order')}}</option>

                                        </select>
                                        @error('work_type')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror


                                    </div>
                                    <label for="email" class="control-label"> </label>
                                    @if($delegate->work_type == 3)


                                    <input placeholder="{{__('admin_message.Enter the amount required for one order')}}"
                                        class="" name="payment" type="text" id="payment" value="{{$delegate->payment}}" />
                                    @else
                                    <input placeholder="{{__('admin_message.Enter the amount required for one order')}}"
                                        class="" name="payment" type="text" id="payment" hidden="hidden" />


                                    @endif
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label"> {{__('admin_message.Date of hiring')}}
                                    </label>

                                    <div class="">
                                        <input value="{{$delegate->date}}" type="date" name="date" class="form-control"
                                            id="date">
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
                                    <label for="bank_name" class="control-label">{{__('admin_message.bank name')}}
                                    </label>

                                    <div class="">
                                        <input value="{{$delegate->bank_name}}" type="text" name="bank_name"
                                            class="form-control" id="bank_name">
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
                                    <label for="bank_account_number"
                                        class="control-label">{{__('admin_message.bank account number')}}
                                    </label>

                                    <div class="">
                                        <input value="{{$delegate->bank_account_number}}" type="text"
                                            name="bank_account_number" class="form-control" id="bank_account_number">
                                        @error('bank_account_number')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">{{__('admin_message.vehicle')}}</label>
                                    <div class="">
                                        <select id="vehicle_id" name="vehicle_id" class="form-control select2">
                                            <option value="0">{{__('admin_message.Select')}}
                                                {{__('admin_message.vehicle')}}</option>

                                            @foreach($Vehicles as $Vehicle)

                                            <option  {{($delegate->vehicle_id == $Vehicle->id)? 'selected' : ''}} value="{{$Vehicle->id}}">
                                                {{$Vehicle->type_en}}-{{$Vehicle->vehicle_number_en}}
                                            </option>

                                            @endforeach

                                        </select>
                                        @error('vehicle_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="documents">
                            <div class="col-md-6">
                                <div class="form-group">
                                <div class=" image">
                                @if($delegate->avatar==NULL)
                                <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @else
                                <img src="{{asset('storage/'.$delegate->avatar)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @endif
                               
                                </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">{{__('admin_message.personal photo')}}</label>
                                        <input name="avatar" type="file" id="exampleInputFile">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <div class=" image">
                                @if($delegate->license_photo==NULL)
                                <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @else
                                <img src="{{asset('storage/'.$delegate->license_photo)}}" class="img-circle" alt="User Image"
                                            width="130">
                                @endif
                                </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">{{__('admin_message.license photo')}} </label>
                                        <input name="license_photo" type="file" id="exampleInputFile">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <div class=" image">
                                @if($delegate->residence_photo==NULL)
                                <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @else
                                <img src="{{asset('storage/'.$delegate->residence_photo)}}" class="img-circle" alt="User Image"
                                            width="130">
                                @endif
                                </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile"> {{__('admin_message.residence photo')}} </label>
                                        <input name="residence_photo" type="file" id="exampleInputFile">

                                    </div>
                                </div>
                            </div>




                        </div>


                        <div class=" footer">
                            <input type="hidden" name="user_type" value="delegate">
                            <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
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
$("#work_type").change(function() {
    var selected_option = $('#work_type').val();

    if (selected_option === '3') {
        $('#payment').attr('pk', '1').show();
        $('#payment').addClass('form-control');

    }
    if (selected_option != '3') {
        $("#payment").removeAttr('pk').hide();
    }
})
</script>


@endsection