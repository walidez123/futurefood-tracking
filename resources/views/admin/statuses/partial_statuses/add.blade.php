@extends('layouts.master')
@section('pageTitle', __('admin_message.status'))
@section('css')
<link rel="stylesheet"
    href="{{asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">

@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('admin_message.status'), 'type' =>__('admin_message.Add'), 'iconClass' => 'fa-bookmark', 'url' =>
    route('statuses.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">
{{-- value="{{$foodics_statuses ? $foodics_statuses->assigned_id : ''}}" --}}
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
            @foreach(auth()->user()->companyWorks as $type)
                @if($type->work == 1)
                    @include('admin.statuses.partial_statuses.salla')
                    @include('admin.statuses.partial_statuses.zid')
                    @include('admin.statuses.partial_statuses.blink')
                    @include('admin.statuses.partial_statuses.aymakan')
                @elseif($type->work == 2)
                    @include('admin.statuses.partial_statuses.foodics')
                @elseif($type->work == 4 || $type->work == 1)
                    @include('admin.statuses.partial_statuses.smb')
                @endif

            @endforeach
                       
           
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
</script>
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection