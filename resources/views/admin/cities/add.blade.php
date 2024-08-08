@extends('layouts.master')
@section('pageTitle', __("admin_message.Add a new city"))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __("admin_message.City"), 'type' => __("admin_message.Add"), 'iconClass' => 'fa-map-marker', 'url' => route('cities.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('CityCompany.store')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{ __("admin_message.Add a new city") }} </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->


                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"> {{ __("admin_message.Abbreviation of the city name") }} </label>
                                <input type="text" class="form-control" name="abbreviation" id="exampleInputEmail1"
                                    placeholder="{{ __('app.enter ths abbreviation of city name') }}">
                                @error('abbreviation')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"> {{ __("admin_message.City name in English") }} </label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="{{ __("admin_message.City name in English") }} ">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> {{ __("admin_message.City name in Arabic") }} </label>
                                <input type="text" class="form-control" name="title_ar" id="exampleInputEmail1"
                                    placeholder="{{ __("admin_message.City name in Arabic") }}">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="longitude">(longitude ) {{ __("admin_message.Meridians") }} </label>
                                <input type="text" class="form-control" name="{{ __("admin_message.longitude") }}" id="exampleInputEmail1" placeholder="{{ __("app.latitudes") }}">
                            </div>
                            <div class="form-group">
                                <label for="latitude">(latitude ) {{ __("admin_message.latitudes") }} </label>
                                <input type="text" class="form-control" name="latitude" id="exampleInputPassword1"
                                    placeholder="{{ __("admin_message.latitude") }}">
                            </div>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">{{ __("admin_message.save") }}</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
