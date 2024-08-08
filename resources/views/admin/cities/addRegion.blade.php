@extends('layouts.master')
@section('pageTitle',__('admin_message.neighborhood'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('admin_message.neighborhood'), 'type' =>__('admin_message.Add'), 'iconClass' => 'fa-map-marker', 'url' => route('RegionCompany.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('RegionCompany.store')}}" method="POST">
            <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">

                @csrf


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{__('admin_message.Add')}} {{__('admin_message.neighborhood')}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                            <label for="name">{{__('admin_message.Title')}} {{__('admin_message.English')}}</label>
                                <input type="text" class="form-control" value="{{old('title_ar')}}" name="title" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Title')}} {{__('admin_message.English')}}">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">{{__('admin_message.Title')}} {{__('admin_message.Arabic')}}</label>
                                    <input type="text" class="form-control" value="{{old('title_ar')}}" name="title_ar" id="exampleInputEmail1"
                                        placeholder="{{__('admin_message.Title')}} {{__('admin_message.Arabic')}}">
                                    @error('title_ar')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            <div class="form-group">
                            <label for="name">{{__('admin_message.City')}}</label>
                                <select required  class="form-control select2" name="city_id" >
                                <option value="">{{__('admin_message.Select')}} {{__('admin_message.City')}}</option>

                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->trans('title')}}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="latitude">{{__('admin_message.longitude')}} </label>
                                <input type="text" class="form-control" name="longitude" id="exampleInputEmail1" placeholder="longitude">
                                @error('longitude')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                            <label for="latitude">{{__('admin_message.latitude')}} </label>
                                <input type="text" class="form-control" name="latitude" id="exampleInputPassword1"
                                    placeholder="latitude">
                                    @error('latitude')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>

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