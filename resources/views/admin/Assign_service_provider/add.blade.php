@extends('layouts.master')
@section('pageTitle',  __('admin_message.Add a new rule'))
@section('nav')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        {{-- @include('layouts._header-form', [
            'title' => '{{__("admin_message.rule")}}',
            'type' => '{{__("admin_message.Add")}}',
            'iconClass' => 'fa-map-marker',
            'url' => route('Rule_service_provider.index'),
            'multiLang' => 'false',
        ]) --}}
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
                <form id="formRuls" action="{{ route('Rule_service_provider.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ Auth()->user()->company_id }}">
                    <input type="hidden" name="type" value="2">
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <h3 class="box-title">{{ __('admin_message.Add a new rule') }}</h3>
                            <div class="box-body" style="overflow-x: auto !important">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('admin_message.Designation name') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="title"
                                            id="exampleInputEmail1" required
                                            placeholder="{{ __('admin_message.Designation name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">{{ __('admin_message.details') }}<span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="details" required
                                            id="exampleInputEmail1" placeholder="{{ __('admin_message.details') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin_message.status') }}<span
                                                style="color: red">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="1">{{ __('admin_message.active') }}</option>
                                            <option value="0">{{ __('admin_message.not active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max">{{ __('admin_message.Maximum order limit') }}</label>
                                        <input type="number" name="max" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_type">{{ __('admin_message.Type of Request') }}<span
                                                style="color: red">*</span></label>
                                        <select name="work_type" class="form-control work_id"  id="work_type" required>
                                            <option value="">{{ __('admin_message.Choose a type') }}</option>
                                            <option value="1">{{ __('admin_message.Client') }}</option>
                                            <option value="2">{{ __('admin_message.restaurant') }}</option>
                                            <option value="4">{{ __('fulfillment.fulfillment') }}</option>                                      
                                         </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delegate_id">{{ __('admin_message.Service provider') }}<span
                                                style="color: red">*</span></label>
                                             <select required class="form-control select2" id="service_id" name="delegate_id"
                                            required>
                                            <option value="">{{ __('admin_message.Select') }} {{ __('admin_message.Service provider') }}
                                            </option>
                                            @foreach ($service_providers as $service_provider)
                                                <option value="{{ $service_provider->serviceProvider->id }}">{{ $service_provider->serviceProvider->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                <label for="client_id">{{ __('admin_message.Client') }}</label>
                                <select id="client_assign" class="form-control select2  client_assign" name="client_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a client') }}
                                    </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col-md-6">
                                <label for="address_assign_id">{{ __('admin_message.addresses') }}</label>
                                <select id="" class="form-control select2 address_assign_id" name="address_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a addresses') }}
                                    </option>
                                  
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div style="display: flex;width: 100%;">
                            <button id="submit-button" type="submit" class="btn btn-info"
                                style="margin-left: 15px;margin-right: 15px">{{ __('admin_message.Add a sub-rule') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    {{-- <script>
        $(function() {
            $('.select2').select2()
        });
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   
@endsection
