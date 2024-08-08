@extends('layouts.master')
@section('pageTitle', __('app.address'))
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
    @include('layouts._header-form', ['title' => __('app.address'), 'type' => __('app.add'), 'iconClass' => 'fa-map-marker', 'url' =>
    route('addresses.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{url('admin/clients/address_store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" >
                @csrf
                <input type="hidden" name="id" value={{$id}}>

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">

                        <!-- form start -->

                        <div class="box-body">
                               <div class="form-group">
                                <label for="firstname" class="control-label">@lang('app.address') *</label>

                                <div class="">
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                         required>
                                    @error('address')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="control-label">@lang('app.city') *</label>
                                <div class="">
                                    <select id="city_id" class="form-control select2" name="city_id" >
                                        <option value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                        @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->title_ar}}</option>
                                        @endforeach

                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="form-group">
                             <label for="lastname" class="control-label">@lang('app.neighborhood') *</label>
                                <div class="">
                                    <select id="neighborhood_id" class="form-control select2" name="neighborhood_id" >
                                      

                                    </select>
                                    @error('neighborhood_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="control-label">@lang('address.The main branch') *</label>
                                <div class="">
                                    <select id="" class="form-control select2" name="main_address" >
                                        <option value="0">{{__('admin_message.No')}}</option>
                                        <option value="1">{{__('admin_message.Yes')}}</option>

                                    </select>
                                    @error('main_address')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.detials', ['attribute' => '']) </label>

                                <div class="">
                                    <textarea name="description" class="form-control" id="inputEmail">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="control-label">@lang('app.phone')</label>

                                <div class="">
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="phone" >
                                    @error('phone')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @include('partial.address_option')
                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
        </div>
        </form> <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_maps.key')}}&language=ar"></script>
<script type="text/javascript" src="{{asset('assets/bower_components/admin/address_options.js')}}"></script>  
<script type="text/javascript" src="{{asset('assets/bower_components/admin/show_map.js')}}"></script> 
@endsection
