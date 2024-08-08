@extends('layouts.master')
@section('pageTitle', __('admin_message.Site settings'))
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('admin_message.Site settings'), 'type' => __('admin_message.Edit'), 'iconClass' => 'fa fa-cog', 'url'
    =>
    route('settings.edit'), 'multiLang' => 'flase'])

    <!-- Main content -->

    <section class="content ">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <form action="{{route('settings.update.company')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#App" data-toggle="tab"
                                    aria-expanded="true">{{__('admin_message.Company Data')}}
                                </a></li>



                            <li class=""><a href="#Massage" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Messages Setting')}}
                                </a>
                            </li>

                          

                        

                        </ul>
                    </div>
                    <div class="tab-content">
                        <!--  -->
                       <!--  -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="App">
                            <div class="form-group">

                                <label for="exampleInputEmail1">{{ __('admin_message.logo') }}</label>
                                <img src="{{ asset('storage/' . $user->logo) }}" class="img-responsive"
                                    alt="Admin Icon Image" width="120">
                                <input type="file" class="form-control" name="logo" id="">

                                @error('logo')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- titles -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Title') }} {{ __('admin_message.English') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $user->title }}" name="title"
                                    placeholder="{{ __('admin_message.Title') }}" >
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Title') }} {{ __('admin_message.Arabic') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $user->title_ar }}" name="title_ar"
                                    placeholder="{{ __('admin_message.title') }}" >
                                @error('title_ar')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- titles -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Phone') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $user->phone }}" name="phone"
                                    placeholder="{{ __('admin_message.Phone') }}" >
                                @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Email') }}</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    value="{{ $user->email }}" name="email"
                                    placeholder="{{ __('admin_message.Email') }}" >
                                @error('email')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('admin_message.Main branch address') }}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ $user->address }}" name="address" placeholder="address" >
                                @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>                  
                     
                        <div class="tab-pane" id="Massage">
                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.messaging service provider') }}</label>

                                <div class="">
                                    <select type="text" value="{{ $user->sms_username }}"
                                        name="Message_service_provider" class="form-control" id="sms_username"
                                        placeholder="  ">
                                        <option value="">{{ __('admin_message.Select')}}
                                            {{ __('admin_message.messaging service provider') }}</option>
                                        <option selected value="Dreams">Dreams</option>
                                    </select>
                                    @error('sms_username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.Username in the messaging service') }}</label>

                                <div class="">
                                    <input type="text" value="{{ $user->sms_username }}" name="sms_username"
                                        class="form-control" id="sms_username" placeholder="  " >
                                    @error('sms_username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xs-12 form-group">
                                <label for="firstname"
                                    class="control-label">{{ __('admin_message.The name to be sent in the messages') }}</label>

                                <div class="">
                                    <input type="text" value="{{ $user->sms_sender_name }}" name="sms_sender_name"
                                        class="form-control" id="sms_sender_name" placeholder="  " >
                                    @error('sms_sender_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="password" class="control-label">{{ __('admin_message.password') }}</label>

                                <div class="">
                                    <input type="password" value="{{ $user->sms_password }}" name="sms_password"
                                        class="form-control" id="password"
                                        placeholder="{{ __('admin_message.password') }}" >
                                    @error('sms_password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="password" class="control-label"> {{ __('admin_message.Token') }} </label>

                                <div class="">
                                    <input type="text" value="{{ $user->token }}" name="token" class="form-control"
                                        id="password" placeholder="token" >
                                    @error('token')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname" class="control-label">{{__('admin_message.WhatsApp message text in English')}}
                                    </label>
                                    ( <label for="">{{__('admin_message.WhatsApp message_note')}}</label>)

                                <div class="">
                                    <input type="text" value="{{$user->what_up_message}}" name="what_up_message"
                                        class="form-control" id="what_up_message" placeholder="  " >
                                    @error('what_up_message')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="firstname" class="control-label"> {{__('admin_message.WhatsApp message text in Arabic')}}</label>
                                ( <label for="">{{__('admin_message.WhatsApp message_note')}}</label>)

                                <div class="">
                                    <input type="text" value="{{$user->what_up_message_ar}}" name="what_up_message_ar"
                                        class="form-control" id="what_up_message" placeholder="  " >
                                    @error('what_up_message_ar')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                       


                    </div>
                    <!--  -->
                    <!-- nav-tabs-custom -->
                    <div class=" footer">
                        <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
                    </div>
                </form>
            </div>

        </div>

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
@endsection