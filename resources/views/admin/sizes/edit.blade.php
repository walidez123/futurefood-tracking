@extends('layouts.master')
@section('pageTitle', ' تعديل حجم')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' => 'حجم', 'type' => 'تعديل', 'iconClass' => 'fa-map-marker', 'url' => route('sizes.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('sizes.update', $Size->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> تعديل حجم </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                               
                            <div class="box-body">
                            <div class="form-group">
                                <label for="name"> أسم {{__('admin_message.English')}}   </label>
                                <input value="{{$Size->name_en}}" required type="text" class="form-control" name="name_en" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> أسم {{__('admin_message.Arabic')}}   </label>
                                <input value="{{$Size->name_ar}}" required type="text" class="form-control" name="name_ar" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                   
                         
                            <div class="form-group">
                                <label for="longitude">  الطول</label>
                                <input value="{{$Size->length}}" type="text" class="form-control" name="length" id="exampleInputEmail1" placeholder="length">
                            </div>
                            <div class="form-group">
                                <label for="latitude"> العرض</label>
                                <input value="{{$Size->width}}" type="text" class="form-control" name="width" id="exampleInputPassword1"
                                    placeholder="width">
                            </div>
                            <div class="form-group">
                                <label for="latitude"> الإرتفاع</label>
                                <input value="{{$Size->height}}" type="text" class="form-control" name="height" id="exampleInputPassword1"
                                    placeholder="height">
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