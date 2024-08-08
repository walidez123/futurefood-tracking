@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))

@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    @if(session('success'))
                    <div id="success-alert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div id="error-alert" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif


                    @if ($errors->any())
                    <div id="error-alert" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="tab-content">
                        <div class="active tab-pane" id="filter1">
                            <div class="row ">
                                <form action="{{ route('Export_Reports_excel.store') }}" method="post" class="col-xs-12">
                                @csrf

                                    <input type="hidden" name="work_type" value="{{ $work_type }}">
                                    <input type="hidden" name="type" value="ship">

                                    <div class="col-lg-6">
                                        @if ($work_type == 1)
                                        <label>{{ __('admin_message.Clients') }}</label>
                                        @elseif($work_type == 4)
                                        <label>{{ __('fulfillment.fulfillment_clients') }}</label>

                                        @else
                                        <label>{{ __('admin_message.restaurants') }}</label>
                                        @endif
                                        <select class="form-control select2" name="user_id">
                                            @if ($work_type == 1)
                                            <option value="">
                                                {{ __('admin_message.Choose a store') }}</option>
                                            </option>
                                            @elseif ($work_type == 4)
                                            <option value="">
                                                {{ __('admin_message.Choose a fulfillment') }}
                                            </option>

                                            @else
                                            <option value="">
                                                {{ __('admin_message.Choose a restaurant') }}
                                            </option>
                                            @endif
                                            @foreach ($clients as $client)
                                            <option {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                value="{{ $client->id }}">{{ $client->name }} |
                                                {{ $client->store_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.statuses') }}</label>
                                        <select class="form-control select2" name="status_id">
                                            <option value="">
                                                {{ __('admin_message.Choose a statuses') }}</option>

                                            @foreach ($statuses as $status)
                                            <option
                                                {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }}
                                                value="{{ $status->id }}">{{ $status->trans('title') }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.The delegates') }}</label>
                                        <select class="form-control select2" name="delegate_id">
                                            <option value="">
                                                {{ __('admin_message.Select a delegate') }}</option>
                                            @foreach ($delegates as $client)
                                            <option
                                                {{ isset($delegate_id) && $delegate_id == $client->id ? 'selected' : '' }}
                                                value="{{ $client->id }}">{{ $client->name }} |
                                                {{ $client->store_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.PaidOrNot') }}</label>
                                        <select class="form-control select2" name="paid">
                                            <option value="">{{ __('admin_message.select') }}
                                            </option>
                                            <option
                                                {{ isset($paid) && $paid == 1 ? 'selected' : '' }}
                                                value="1">{{ __('admin_message.Paid') }}</option>
                                            <option
                                                {{ isset($paid) && $paid == 0 ? 'selected' : '' }}
                                                value="0">{{ __('admin_message.UnPaid') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.from') }}</label>
                                        <input type="date" name="from" value="{{ isset($from) ? $from : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label for="to">{{ __('admin_message.to') }}</label>
                                            <input type="date" name="to" value="{{ isset($to) ? $to : '' }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.from city') }}</label>
                                        <select class="form-control select2 col-md-12" name="sender_city">
                                            <option value="">
                                                {{ __('admin_message.Select a city') }}</option>
                                            @if (!empty($cities))
                                            @foreach ($cities as $city)
                                            <option
                                                {{ isset($sender_city) && $sender_city == $city->id ? 'selected' : '' }}
                                                value="{{ $city->id }}">
                                                {{ $city->trans('title') }}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.to city') }}</label>
                                        <select class="form-control select2" name="receved_city">
                                            <option value="">{{ __('admin_message.from city') }}
                                            </option>
                                            @if (!empty($cities))
                                            @foreach ($cities as $city)
                                            <option
                                                {{ isset($receved_city) && $receved_city == $city->id ? 'selected' : '' }}
                                                value="{{ $city->id }}">
                                                {{ $city->trans('title') }}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <!-- service provider -->
                                    <div class="col-lg-6">
                                        <label>{{ __('admin_message.Service provider') }}</label>
                                        <select class="form-control select2" name="service_provider_id">
                                            <option value="">{{ __('admin_message.Choose a  Service Provider') }}
                                            </option>
                                            @if (!empty($service_providers))
                                            @foreach ($service_providers as $service_provider)
                                            <option
                                                {{ isset($service_provider_id) && $service_provider_id == $service_provider->serviceProvider->id ? 'selected' : '' }}
                                                value="{{ $service_provider->serviceProvider->id }}">
                                                {{ $service_provider->serviceProvider->name }}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">

                                <div class="col-lg-6">
                                    <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                        value="{{ __('admin_message.Extract the Excel sheet') }}" />
                                </div>
                             

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section></div>
    @endsection
    