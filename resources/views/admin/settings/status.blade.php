@extends('layouts.master')
@section('pageTitle', __('admin_message.Site settings'))
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('admin_message.Site settings'), 'type' =>__('admin_message.Edit') ,
    'iconClass' => 'fa fa-cog', 'url'
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

                            @if(in_array(1,$user_type))

                            <li class="active"><a href="#StatusSetting" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}}
                                    {{__('admin_message.Client')}} </a>
                            </li>
                            @endif

                            @if(in_array(2,$user_type))

                            <li class=""><a href="#StatusSettingRestaurants" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}}
                                    {{__('admin_message.restaurants')}} </a>
                            </li>
                            @endif
                            @if(in_array(4,$user_type))

<li class=""><a href="#StatusSettingfulfilment" data-toggle="tab"
        aria-expanded="false">{{__('admin_message.Status Setting')}}
        {{__('fulfillment.fulfillment')}} </a>
</li>
@endif
                            @if(in_array(1,$user_type))

                            <li class=""><a href="#StatusSettingService_client" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}}
                                    {{__('admin_message.Service provider')}}
                                    {{__('admin_message.Client')}} </a>
                            </li>
                            @endif

                            @if(in_array(2,$user_type))

                            <li class=""><a href="#StatusSettingServiceRestaurants" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}}
                                    {{__('admin_message.Service provider')}}
                                    {{__('admin_message.restaurants')}} </a>
                            </li>
                            @endif
                            
                            @if(in_array(4,$user_type))

                            <li class=""><a href="#StatusSettingServiceFulfmient" data-toggle="tab"
                                    aria-expanded="false">{{__('admin_message.Status Setting')}}
                                    {{__('admin_message.Service provider')}}
                                    {{__('fulfillment.fulfillment')}} </a>
                            </li>
                            @endif
                            










                        </ul>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane active" id="StatusSetting">
                            @if(in_array(1,$user_type))
                            @include('admin.settings.statusStore')
                            @endif

                        </div>
                        <div class="tab-pane " id="StatusSettingRestaurants">
                            @if(in_array(2,$user_type))
                            @include('admin.settings.statusRes')
                            @endif
                        </div>
                        <div class="tab-pane " id="StatusSettingfulfilment">
                        @if(in_array(4,$user_type))

                        @if (in_array(2, $user_type))

<div class="col-md-6">

<div class="form-group">
    <label 
    for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, after which it is not useful to change the status for fulfillment') }}</label>
    <select class="form-control" name="stutus_fulfilment" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->fulfillment_appear == 1)
        <option {{ $user->stutus_fulfilment == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('default_status_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif


                        @endif


                        
                        </div>
                        <div class="tab-pane " id="StatusSettingService_client">
                            @if(in_array(1,$user_type))


                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Send order to service provider') }}</label>
                                <select class="form-control" name="send_order_service_provider">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->shop_appear == 1)
                                    <option {{ $user->send_order_service_provider == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('send_order_service_provider')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Return order to service provider') }}</label>
                                <select class="form-control" name="Return_order_service_provider">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->shop_appear == 1)
                                    <option {{ $user->Return_order_service_provider == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('Return_order_service_provider')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Cancel order to service provider') }}</label>
                                <select class="form-control" name="cancel_order_service_provider">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->shop_appear == 1)
                                    <option {{ $user->cancel_order_service_provider == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('cancel_order_service_provider')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @endif
                        </div>
                        <div class="tab-pane " id="StatusSettingServiceRestaurants">
                            @if(in_array(2,$user_type))


                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Send order to service provider') }}</label>
                                <select class="form-control" name="send_order_service_provider_R">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->restaurant_appear == 1)
                                    <option {{ $user->send_order_service_provider_R == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('send_order_service_provider_R')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Return order to service provider') }}</label>
                                <select class="form-control" name="Return_order_service_provider_R">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->restaurant_appear == 1)
                                    <option
                                        {{ $user->Return_order_service_provider_R == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('Return_order_service_provider_R')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Cancel order to service provider') }}</label>
                                <select class="form-control" name="cancel_order_service_provider_R">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->restaurant_appear == 1)
                                    <option
                                        {{ $user->cancel_order_service_provider_R == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('cancel_order_service_provider_R')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @endif

                        </div>
                        <div class="tab-pane " id="StatusSettingServiceFulfmient">
                            @if(in_array(2,$user_type))


                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Send order to service provider') }}</label>
                                <select class="form-control" name="send_order_service_provider_F">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->fulfillment_appear == 1)
                                    <option {{ $user->send_order_service_provider_F == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('send_order_service_provider_F')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Return order to service provider') }}</label>
                                <select class="form-control" name="Return_order_service_provider_F">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->fulfillment_appear == 1)
                                    <option
                                        {{ $user->Return_order_service_provider_F == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('Return_order_service_provider_F')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleInputEmail1">{{ __('admin_message.Cancel order to service provider') }}</label>
                                <select class="form-control" name="cancel_order_service_provider_F">
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                                    </option>
                                    @foreach ($Status as $status)
                                    @if ($status->fulfillment_appear == 1)
                                    <option
                                        {{ $user->cancel_order_service_provider_F == $status->id ? 'selected' : '' }}
                                        value="{{ $status->id }}">{{ $status->trans('title') }}</option>
                                    @endif
                                    @endforeach


                                </select>
                                @error('cancel_order_service_provider_F')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @endif

                        </div>





                        <!--  -->
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