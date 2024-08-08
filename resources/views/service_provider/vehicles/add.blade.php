@extends('layouts.master')
@section('pageTitle',  __("admin_message.vehicle"))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __("admin_message.vehicle"), 'type' => __("admin_message.Add"), 'iconClass' => 'fa-car', 'url' => route('vehicles.index'), 'multiLang' => 'false'])

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

            <form enctype="multipart/form-data" action="{{route('s_p_vehicles.store')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">
                <input type="hidden" name="service_provider_id" value="{{Auth()->user()->id}}">


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __("admin_message.Add") }} {{ __("admin_message.vehicle") }}  </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">{{ __("admin_message.type") }}</label>
                                <input required type="text" class="form-control" name="type_en" id="exampleInputEmail1"
                                    placeholder='{{ __("admin_message.type") }}'>
                                @error('type_en')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group">
                                <label for="name">{{ __("admin_message.type") }} ({{ __("admin_message.Arabic") }})</label>
                                <input required type="text" class="form-control" name="type_ar" id="exampleInputEmail1"
                                    placeholder='{{ __("admin_message.type") }}'>
                                @error('type_ar')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> -->
                            <div class="form-group">
                                <label for="name">{{ __("admin_message.vehicle_number") }} </label>
                                <input required type="text" class="form-control" name="vehicle_number_en" id="exampleInputEmail1"
                                    placeholder='{{ __("admin_message.vehicle_number") }}'>
                                @error('vehicle_number_en')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group">
                                <label for="longitude">{{ __("admin_message.vehicle_number") }} ({{ __("admin_message.Arabic") }})</label>
                                <input type="text" class="form-control" name="vehicle_number_ar" id="exampleInputEmail1" placeholder='{{ __("admin_message.vehicle_number") }}'>
                            </div> -->
                            <div class="form-group">
                                <label for="latitude">{{ __("admin_message.image") }}</label>
                                <input type="file" class="form-control" name="image" id="exampleInputPassword1"
                                    placeholder="latitude">
                                    @error('image')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection