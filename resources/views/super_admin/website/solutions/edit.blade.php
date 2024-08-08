@extends('layouts.master')
@section('pageTitle', 'Edit service')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => 'Service',
            'type' => 'Edit',
            'iconClass' => 'fa fa-wrench',
            'url' => route('solutions.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form role="form" action="{{ route('solutions.update', $solution->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 col-xs-12">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Edit Service</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class=" image">
                                    <img src="{{ asset('storage/' . $solution->icon_class) }}" class="img-responsive"
                                        alt="User Image" width="130">
                                </div>
                                <div class="form-group" style="margin-top: 15px;">
                                    <label>Image</label>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                    @error('image')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="en">title En</label>
                                    <input type="text" name="title_en" value="{{ $solution->title_en }}"
                                        class="form-control en" id="exampleInputEmail1" placeholder="title ">
                                    <label for="exampleInputEmail1" class="ar">title Ar</label>
                                    <input type="text" name="title_ar" value="{{ $solution->title_ar }}"
                                        class="form-control ar" id="exampleInputEmail1" placeholder="العنوان ">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="en">details En</label>
                                    <textarea class="form-control en" name="details_en" id="exampleInputEmail1">{{ $solution->details_en }}</textarea>
                                    <label for="exampleInputEmail1" class="ar">details Ar</label>
                                    <textarea class="form-control ar" name="details_ar" id="exampleInputEmail1">{{ $solution->details_ar }}</textarea>
                                </div>
                                <div class=" footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
