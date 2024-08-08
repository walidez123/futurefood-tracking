@extends('layouts.master')
@section('pageTitle', 'Add what we do')
@section('nav')
    @include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'what we do', 'type' => 'Add', 'iconClass' => 'fa fa-question-circle', 'url' =>
    route('what-we-do.index'), 'multiLang' => 'false'])


    <!-- Main content -->
        <section class="content">
            <div class="row">

                <form role="form" action="{{route('what-we-do.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12 col-xs-12">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Add what we do</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">

                                <div class="form-group">

                                    <div class="form-group" style="margin-top: 15px;">
                                        <label>Image</label>
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg"  required>
                                        @error('icon_class')
                                        <span class="invalid-feedback text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="en">title En</label>
                                    <label class="ar">title Ar</label>
                                    <input type="text" name="title_en" class="form-control en"
                                           placeholder="title ">
                                    <input type="text" name="title_ar" class="form-control ar"
                                           placeholder="العنوان ">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="en">details En</label>
                                    <label for="exampleInputEmail1" class="ar">details Ar</label>
                                    <textarea class="form-control en" name="details_en"
                                              ></textarea>
                                    <textarea class="form-control ar" name="details_ar"
                                              ></textarea>
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

    </div><!-- /.content-wrapper -->
@endsection
