@extends('layouts.master')
@section('pageTitle', 'تعديل الحى')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' => 'الحى', 'type' => 'تعديل', 'iconClass' => 'fa-map-marker', 'url' => route('neighborhoods.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('neighborhoods.update', $neighborhood->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> تعديل الحى </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
    
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">الأسم</label>
                                    <input required type="text" class="form-control" value="{{$neighborhood->title}}" name="title" id="exampleInputEmail1"
                                        placeholder="Title">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">الأسم بالعربى</label>
                                    <input required type="text" class="form-control" value="{{$neighborhood->title_ar}}" name="title_ar" id="exampleInputEmail1"
                                        placeholder="Title">
                                    @error('title_ar')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label for="name">المدينة</label>
                                <select required  class="form-control select2" name="city_id" >
                                    @foreach($cities as $city)
                                    @if($neighborhood->city_id==$city->id)
                                    <option selected value="{{$city->id}}">{{$city->title}}</option>
                                    @else
                                    <option  value="{{$city->id}}">{{$city->title}}</option>


                                    @endif



                                    @endforeach
                                </select>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                                <div class="form-group">
                                    <label for="longitude">longitude</label>
                                    <input type="text" class="form-control" value="{{$neighborhood->longitude}}"  name="longitude" id="exampleInputEmail1" placeholder="longitude">
                                </div>
                                <div class="form-group">
                                    <label for="latitude">latitude </label>
                                    <input type="text" class="form-control" value="{{$neighborhood->latitude}}" name="latitude" id="exampleInputPassword1"
                                        placeholder="latitude">
                                </div>
    
                            </div>
                        </div><!-- /.box -->
                    </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection