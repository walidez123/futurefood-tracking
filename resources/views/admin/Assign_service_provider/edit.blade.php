@extends('layouts.master')
@section('pageTitle', __('admin_message.edit rule'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
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
                <form id="formRuls" action="{{ route('Rule_service_provider.update', $Orders_rules->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="orders_rules_id" id="orders_rules_id" value="{{ $Orders_rules->id }}">
                    <div class="col-md-12">
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ __('admin_message.edit rule') }}</h3>
                            </div>
                            <div class="box-body" style="overflow-x: auto !important">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="designation_name">{{ __('admin_message.Designation name') }}</label>
                                        <input type="text" class="form-control" value="{{ $Orders_rules->title }}"
                                            name="title" id="exampleInputEmail1"
                                            placeholder="{{ __('admin_message.Designation name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="details">{{ __('admin_message.details') }}</label>
                                        <input type="text" class="form-control" value="{{ $Orders_rules->details }}"
                                            name="details" id="exampleInputEmail1"
                                            placeholder="{{ __('admin_message.details') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin_message.status') }}</label>
                                        <select name="status" class="form-control">
                                            <option {{ $Orders_rules->status == 1 ? 'selected' : '' }} value="1">
                                                {{ __('admin_message.active') }}</option>
                                            <option {{ $Orders_rules->status == 0 ? 'selected' : '' }} value="0">
                                                {{ __('admin_message.not active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max">{{ __('admin_message.Maximum order limit') }}</label>
                                        <input type="number" name="max" class="form-control"
                                            value="{{ $Orders_rules->max }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">{{ __('admin_message.Type of Request') }}</label>
                                        <select name="work_type" class="form-control work_id" id="work_type">

                                            <option value="">{{ __('admin_message.Choose a type') }}</option>

                                            <option {{ $Orders_rules->work_type ==1 ? 'selected' : '' }} value="1">
                                                {{ __('admin_message.Client') }}</option>
                                            <option {{ $Orders_rules->work_type ==2 ? 'selected' : '' }} value="2">
                                                {{ __('admin_message.restaurant') }}</option>
                                                <option {{ $Orders_rules->work_type ==4 ? 'selected' : '' }} value="4">
                                                {{ __('fulfillment.fulfillment') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="delegate_id">{{ __('admin_message.Service provider') }}</label>
                                        <select class="form-control select2" id="service_id" name="delegate_id">
                                        <option value="">{{ __('admin_message.Select') }} {{ __('admin_message.Service provider') }}
                                            </option>
                                            @foreach ($service_providers as $service_provider)
                                                <option {{ $Orders_rules->delegate_id == $service_provider->serviceProvider->id ? 'selected' : '' }}  value="{{ $service_provider->id }}">{{ $service_provider->serviceProvider->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-6">
                                <label for="client_id">{{ __('admin_message.Client') }}</label>
                                <select id="client_assign" class="form-control select2  client_assign" name="client_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a client') }}
                                    </option>
                                    @foreach ($clients as $client)
                                        <option {{ $Orders_rules->client_id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col-md-6">
                                <label for="address_assign_id">{{ __('admin_message.addresses') }}</label>
                                <select id="" class="form-control select2 address_assign_id" name="address_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a addresses') }}
                                        @foreach ($addresses as $address)
                                        <option {{ $Orders_rules->address_id == $address->id ? 'selected' : '' }} value="{{ $address->id }}">{{ $address->address }}
                                        </option>
                                    @endforeach

                                    </option>
                                  
                                </select>
                            </div>
                            </div>





                                <!--  -->
                            </div>

                        </div><!-- /.box -->
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
    <script>
        $(function() {
            $('.select2').select2()
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   
@endsection
