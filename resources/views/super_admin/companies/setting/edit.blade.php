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
                <form enctype="multipart/form-data" action="{{route('companies.setting.edit')}}" method="POST"
                    class="box  col-md-12" style="border: 0px; padding:10px;">
                    @csrf
                    <input type="hidden" name="company_id" value="{{$company->id}}">
                    <input type="hidden" name="id" value="{{$setiing->id}}">



                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#App" data-toggle="tab"
                                    aria-expanded="true">{{__('admin_message.Company Data')}}
                                </a></li>



                            <li class=""><a href="#Massage" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Messages Setting')}}
                                </a>
                            </li>

                            <li class=""><a href="#StatusSetting" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}} </a>
                            </li>
                            @if(in_array(1,$setiing_type))
                            <li><a href="#Termsmile"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Last mile)')}}
                                </a></li>
                            @endif
                            @if(in_array(2,$setiing_type))

                            <li><a href="#Termres"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Restaurants)')}}
                                </a></li>
                            @endif

                            @if(in_array(3,$setiing_type))

                            <li><a href="#Terms10"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Warehouses)')}}
                                </a></li>
                            @endif








                        </ul>
                    </div>
                    <div class="tab-content">
                        <!--  -->






                        <!--  -->

                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="App">
                            <div class="form-group">

                                <label for="exampleInputEmail1">{{ __('admin_message.logo') }}</label>
                                <img src="{{ asset('storage/' . $setiing->logo) }}" class="img-responsive"
                                    alt="Admin Icon Image" width="120">
                                <input type="file" class="form-control" name="logo" id="">

                                @error('logo')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Phone') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $setiing->phone }}" name="phone"
                                    placeholder="{{ __('admin_message.Phone') }}" required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Email') }}</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    value="{{ $setiing->email }}" name="email"
                                    placeholder="{{ __('admin_message.Email') }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Main branch address') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $setiing->address }}" name="address" placeholder="address" required>
                                @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>



                        </div>

                        <div class="tab-pane" id="StatusSetting">
                            @if(in_array(1,$setiing_type))
                            @include('super_admin.companies.setting.statusStore')
                            @endif
                            @if(in_array(2,$setiing_type))
                            @include('super_admin.companies.setting.statusRes')
                            @endif
                           
                               
                        </div>

                        <div class="tab-pane" id="Massage">
                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.messaging service provider') }}</label>

                                <div class="">
                                    <select type="text" value="{{ $setiing->sms_username }}"
                                        name="Message_service_provider" class="form-control" id="sms_username"
                                        placeholder="  ">
                                        <option value="">{{ __('admin_message.Select')}}
                                            {{ __('admin_message.messaging service provider') }}</option>
                                        <option selected value="Dreams">Dreams</option>
                                    </select>
                                    @error('sms_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.Username in the messaging service') }}</label>

                                <div class="">
                                    <input type="text" value="{{ $setiing->sms_username }}" name="sms_username"
                                        class="form-control" id="sms_username" placeholder="  " required>
                                    @error('sms_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.The name to be sent in the messages') }}</label>

                                <div class="">
                                    <input type="text" value="{{ $setiing->sms_sender_name }}" name="sms_sender_name"
                                        class="form-control" id="sms_sender_name" placeholder="  " required>
                                    @error('sms_sender_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="password" class="control-label">{{ __('admin_message.password') }}</label>

                                <div class="">
                                    <input type="password" value="{{ $setiing->sms_password }}" name="sms_password"
                                        class="form-control" id="password"
                                        placeholder="{{ __('admin_message.password') }}" required>
                                    @error('sms_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="password" class="control-label"> {{ __('admin_message.Token') }} </label>

                                <div class="">
                                    <input type="text" value="{{ $setiing->token }}" name="token" class="form-control"
                                        id="password" placeholder="token" required>
                                    @error('token')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{__('admin_message.WhatsApp message text in English')}}
                                </label>
                                ( <label for="">{{__('admin_message.WhatsApp message_note')}}</label>)

                                <div class="">
                                    <input type="text" value="{{$setiing->what_up_message}}" name="what_up_message"
                                        class="form-control" id="what_up_message" placeholder="  " required>
                                    @error('what_up_message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname" class="control-label">
                                    {{__('admin_message.WhatsApp message text in English')}}</label>
                                ( <label for="">{{__('admin_message.WhatsApp message_note')}}</label>)

                                <div class="">
                                    <input type="text" value="{{$setiing->what_up_message_ar}}"
                                        name="what_up_message_ar" class="form-control" id="what_up_message"
                                        placeholder="  " required>
                                    @error('what_up_message_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <!--  -->
                        <div class="tab-pane fade" id="Termsmile">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms"
                                        data-toggle="tab">{{__('admin_message.Customer terms and conditions')}} </a>
                                </li>
                              
                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="Terms">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="terms_en"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->terms_en }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="terms_ar"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->terms_ar }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Termres">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms2"
                                        data-toggle="tab">{{__('admin_message.Restaurants terms and conditions')}} </a>
                                </li>
                             
                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="Terms2">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_en_res"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->term_en_res }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_ar_res"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->term_ar_res }}</textarea>
                                        </div>
                                    </div>

                                </div>

                              
                            </div>
                        </div>
                        <!-- warehouser -->
                        <div class="tab-pane fade" id="Terms10">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms12"
                                        data-toggle="tab">{{__('admin_message.Customer terms and conditions')}} </a>
                                </li>

                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="Terms12">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_en_warehouse"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->term_en_warehouse }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_ar_warehouse"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $setiing->term_ar_warehouse }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!--  -->
                    </div>
                    <!--  -->
                    <!-- nav-tabs-custom -->
                    <div class=" footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>


    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>

@endsection