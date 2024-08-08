@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
<style>
.select2-container {
    width: 100% !important;
}
</style>

@endsection

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
                                <form action="{{ route('Export_Accounting_excel.store') }}" method="post" class="col-xs-12">
                                @csrf
                                <input type="hidden" name="cod" value="cod">
                                    <div class="col-lg-4">
                                        <label>{{ __('admin_message.client_cod') }}</label>
                                       
                                        <select class="form-control select2" name="user_id">
                                            <option value="">
                                                {{ __('admin_message.Choose a store') }}</option>
                                            </option>
                                         
                                            @foreach ($clients as $client)
                                            <option {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                value="{{ $client->id }}">{{ $client->name }} |
                                                {{ $client->store_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                  



                                 
                                    <div class="col-lg-4">
                                        <label>{{ __('admin_message.from') }}</label>
                                        <input type="date" name="from" value="{{ isset($from) ? $from : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label for="to">{{ __('admin_message.to') }}</label>
                                            <input type="date" name="to" value="{{ isset($to) ? $to : '' }}"
                                                class="form-control">
                                        </div>
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
    @section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection