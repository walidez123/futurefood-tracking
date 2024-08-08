@extends('layouts.master')
@section('pageTitle', ' تعديل المدينة')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' => 'مدينة', 'type' => 'تعديل', 'iconClass' => 'fa-map-marker', 'url' => route('CityCompany.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('CityCompany.update', $city->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> تعديل المدينة </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                            <div class="form-group">
                                <label for="name">أختصار أسم المدينة  </label>
                                <input type="text" value="{{$city->abbreviation}}" class="form-control" name="abbreviation" id="exampleInputEmail1"
                                    placeholder="enter ths abbreviation of city name">
                                @error('abbreviation')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
    
                            <div class="box-body">
                                <div class="form-group">
                                <label for="name">أسم المدينة باللغه الإنجليزية</label>
                                    <input type="text" class="form-control" value="{{$city->title}}" name="title" id="exampleInputEmail1"
                                        placeholder="Title">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label for="name">أسم المدينة باللغه العريية</label>
                                    <input type="text" class="form-control" value="{{$city->title_ar}}" name="title_ar" id="exampleInputEmail1"
                                        placeholder="Title">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label for="longitude">(longitude ) خطوط الطول</label>
                                    <input type="text" class="form-control" value="{{$city->longitude}}"  name="longitude" id="exampleInputEmail1" placeholder="longitude">
                                </div>
                                <div class="form-group">
                                <label for="latitude">(latitude ) خطوط العرض</label>
                                    <input type="text" class="form-control" value="{{$city->latitude}}" name="latitude" id="exampleInputPassword1"
                                        placeholder="latitude">
                                </div>
    
                            </div>
                        </div><!-- /.box -->
                    </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
            </form> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection